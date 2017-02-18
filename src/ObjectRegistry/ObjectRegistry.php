<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Doctrine\Common\Collections\ArrayCollection;
use Pancoast\Common\ObjectRegistry\Exception\DefaultKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\NoDefaultObjectException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotRegisteredException;
use Pancoast\Common\Util\CachedValidator;
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
     * Collect of object keys that have been lazy loaded
     *
     * @var array
     */
    private $lazyLoadedKeys = [];

    /**
     * @var CachedValidator
     */
    protected static $validator;

    /**
     * Constructor
     *
     * @param array $registryValues
     */
    public function __construct(array $registryValues = [])
    {
        $this->coll = new ArrayCollection();
        static::$validator = new CachedValidator();

        foreach ($registryValues as $objectKey => $object) {
            // Allow array of only keys to be passed
            // Implementations, children can deal with handling null object.
            if (is_int($objectKey)) {
                $objectKey = $object;
                $object = null;
            }

            $this->register($objectKey, $object);
        }
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object = null)
    {
        $this->coll->set(
            static::$validator->getValidatedValue($objectKey, 'string'),
            static::$validator->getValidatedValue($object, ['object', 'null'])
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get($objectKey)
    {
        $objectKey = static::$validator->getValidatedValue($objectKey, 'string');

        if (!$this->isRegisteredKey($objectKey)) {
            throw new ObjectKeyNotRegisteredException(
                sprintf(
                    'Object key \'%s\' not registered in this registry',
                    $objectKey
                )
            );
        }

        $object = $this->coll->get($objectKey);

        if ($object instanceof LazyLoadableObjectInterface && !in_array($objectKey, $this->lazyLoadedKeys)) {
            $object = $object->loadObject($objectKey);

            // prevents loading the object further if loaded object also matched lazy loadable interface
            $this->lazyLoadedKeys[] = $objectKey;
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
        static::$validator->validateType($object, 'object');
        // checked by $this->get() call below
        //static::$validator->validateType($objectKey, ['string', 'null']);

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
        return $this->coll->containsKey(static::$validator->getValidatedValue($objectKey, 'string'));
    }
}
