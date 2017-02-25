<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\ObjectRegistry\Exception\NotLazyLoadableKeyException;
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
     * @param string                             $objectKey Object identifier.
     * @param object|LazyLoadableObjectInterface $object    An object or implementation of LazyLoadableObjectInterface
     *                                                      for lazy loadable objects. Some implementations or
     *                                                      extension of this interface may allow null or default
     *                                                      objects so validation on this is left to implementation
     *
     * @return ObjectRegistryInterface|self
     */
    public function register($objectKey, $object = null);

    /**
     * Register an array of objects
     *
     * The array can either:
     *   - have object keys as array keys and objects as values
     *   - have only object keys as array values in which case `null` will be registered and implementation decides how
     *     to handle it (defaults etc).
     *   - do any combination of those.
     *
     * @param array $objects
     *
     * @return ObjectRegistryInterface|self
     */
    public function registerArray(array $objects);

    /**
     * Get a registered (or lazy loaded) object depending on how it was registered
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
     * Get count of registered objects
     *
     * @return int
     */
    public function getCount();

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

    /**
     * Is the lazy loadable object already loaded
     *
     * @param string $objectKey
     *
     * @return bool
     * @throws NotLazyLoadableKeyException
     */
    public function isLoaded($objectKey);

    /**
     * Is the registered object lazy loadable.
     *
     * @param string $objectKey
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws ObjectKeyNotRegisteredException
     */
    public function isLazyLoadable($objectKey);
}
