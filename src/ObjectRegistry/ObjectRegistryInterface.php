<?php
/**
 * @package       johnpancoast/goalie-backend
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotRegisteredException;

/**
 * A simple registry that can hold any number of any type of object by key.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface ObjectRegistryInterface
{
    /**
     * Register an object to this class
     *
     * @param string $objectKey Object identifier.
     * @param object $object An object.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function register($objectKey, $object);

    /**
     * Get a registered object
     *
     * @param string $objectKey Object identifier
     *
     * @return object Object instance registered in this class to $objectKey.
     * @throws ObjectKeyNotRegisteredException
     * @throws InvalidArgumentException
     */
    public function get($objectKey);

    /**
     * Gets all registered objects with their object keys as array keys
     *
     * @return array
     */
    public function getAll();

    /**
     * Is the object registered to the current registry instance
     *
     * @param object      $object
     * @param null|string $objectKey Optional object key to refine search
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isRegistered($object, $objectKey = null);

    /**
     * Is object key registered to the current registry instance
     *
     * @param string $objectKey
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isRegisteredKey($objectKey);
}
