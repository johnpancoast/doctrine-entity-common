<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Doctrine\Common\Collections\ArrayCollection;
use Pancoast\Common\ObjectRegistry\Exception\NotLazyLoadableKeyException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotRegisteredException;
use Pancoast\Common\Util\Validator;

/**
 * A simple registry that can hold any number of any type of object by key.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ObjectRegistry implements ObjectRegistryInterface
{
    /**
     * @var ArrayCollection
     */
    protected $coll;

    /**
     * Type validator
     *
     * @var Validator
     */
    protected $validator;

    /**
     * @var array
     */
    private $lazyLoadKeys = [];

    /**
     * Constructor
     *
     * @param array                $registryValues
     * @param Validator|null $validator
     */
    public function __construct(array $registryValues = [], Validator $validator = null)
    {
        $this->coll = new ArrayCollection();
        $this->validator = $validator ?: new Validator();

        if (!empty($registryValues)) {
            $this->registerArray($registryValues);
        }
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object = null)
    {
        $this->coll->set(
            $this->validator->getValidatedValue($objectKey, 'string'),
            $this->validator->getValidatedValue($object, ['object', 'null'])
        );

        if ($object instanceof LazyLoadableObjectInterface) {
            $this->lazyLoadKeys[$objectKey] = false;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerArray(array $objects)
    {
        foreach ($objects as $objectKey => $object) {
            // Allow array of only keys to be passed
            if (is_int($objectKey)) {
                $objectKey = $object;
                $object = null;
            }

            $this->register($objectKey, $object);
        }

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function get($objectKey)
    {
        $objectKey = $this->validator->getValidatedValue($objectKey, 'string');

        if (!$this->isRegisteredKey($objectKey)) {
            throw new ObjectKeyNotRegisteredException(
                sprintf(
                    'Object key "%s" not registered in this registry',
                    $objectKey
                )
            );
        }

        $object = $this->coll->get($objectKey);

        // only load lazy loadable objects that haven't already been loaded. this also prevents infinite loops for
        // cases where loaded object are also lazy loadable.
        if ($object instanceof LazyLoadableObjectInterface && !$this->lazyLoadKeys[$objectKey] ) {
            $object = $object->loadObject($objectKey);
            $this->lazyLoadKeys[$objectKey] = true;
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->coll->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getCount()
    {
        return $this->coll->count();
    }

    /**
     * @inheritDoc
     */
    public function isRegistered($object, $objectKey = null)
    {
        $this->validator->validateType($object, 'object');
        // checked by $this->get() call below
        //$this->validator->validateType($objectKey, ['string', 'null']);

        if ($objectKey) {
            return spl_object_hash($object) == spl_object_hash($this->get($objectKey));
        } else {
            foreach ($this->coll as $k => $o) {
                if (spl_object_hash($object) == spl_object_hash($o)) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function isRegisteredKey($objectKey)
    {
        return $this->coll->containsKey($this->validator->getValidatedValue($objectKey, 'string'));
    }

    /**
     * @inheritDoc
     */
    public function isLoaded($objectKey)
    {
        if (!$this->isLazyLoadable($objectKey)) {
            throw new NotLazyLoadableKeyException(sprintf(
                'Object key "%s" is not lazy loadable.',
                $objectKey
            ));
        }

        return $this->lazyLoadKeys[$objectKey];
    }

    /**
     * @inheritDoc
     */
    public function isLazyLoadable($objectKey)
    {
        return isset($this->lazyLoadKeys[$objectKey]);
    }
}
