<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotRegisteredException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;

/**
 * A simple registry that can hold any number of known types of object by key.
 *
 * Similar to ObjectRegistryInterface except the class defines the object types that the registry supports.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface KnownObjectRegistryInterface extends ObjectRegistryInterface
{
    /**
     * {@inheritdoc}
     *
     * If $object is null and a default has been set, it will be used in $object's place.
     *
     * @return $this
     * @throws ObjectNotSupportedException
     * @throws InvalidArgumentException
     */
    public function register($objectKey, $object = null);

    /**
     * @inheritDoc
     *
     * @return object Object instance registered in this class to $objectKey.
     * @throws ObjectKeyNotRegisteredException
     * @throws ObjectKeyNotSupportedException
     * @throws InvalidArgumentException
     */
    public function get($objectKey);

    /**
     * Get default object
     *
     * @return object|null
     */
    public function getDefaultObject();

    /**
     * Default object used when null passed to self::register()
     *
     * @param object $object
     *
     * @return string The object key (as registered to this class)
     */
    public function setDefaultObject($object);

    /**
     * Is object or class supported
     *
     * Even if $objectKey is passed if $class matches a default, it's supported.
     *
     * @param string|object $object    Object or class
     * @param null|string   $objectKey To refine search
     *
     * @return bool
     * @internal param object|string $class Class or object to be checked
     */
    public function isSupported($object, $objectKey = null);

    /**
     * Is object key supported by this registry
     *
     * @param string $objectKey Object key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isSupportedKey($objectKey);

    /**
     * Get supported types for an object key
     *
     * This will return all types that a key can register to, including defaults.
     *
     * @param null|string $objectKey Object key or
     *
     * @return array
     */
    public function getSupportedTypes($objectKey = null);

    /**
     * Get all supported types
     *
     * @return array
     */
    public function getAllSupportedTypes();
}
