<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Doctrine\Common\Collections\ArrayCollection;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotRegisteredException;
use Pancoast\Common\Util\Validator;
use Symfony\Component\Validator\Constraints\Valid;

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
     * Constructor
     */
    public function __construct()
    {
        $this->coll = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object)
    {
        $this->coll->set(
            Validator::getValidatedValue($objectKey, 'string'),
            Validator::getValidatedValue($object, 'object')
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get($objectKey)
    {
        $objectKey = Validator::getValidatedValue($objectKey, 'string');

        if (!$this->isRegisteredKey($objectKey)) {
            throw new ObjectKeyNotRegisteredException(
                sprintf(
                    'Object key \'%s\' not registered in this registry',
                    $objectKey
                )
            );
        }

        return $this->coll->get($objectKey);
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
    public function isRegistered($object, $objectKey = null)
    {
        Validator::validateType($object, 'object');
        // checked by $this->get() call below
        //Validator::validateType($objectKey, ['string', 'null']);

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
        return $this->coll->containsKey(Validator::getValidatedValue($objectKey, 'string'));
    }
}
