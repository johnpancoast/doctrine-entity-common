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
     * @return $this
     * @throws ObjectNotSupportedException
     * @throws InvalidArgumentException
     */
    public function register($objectKey, $object);

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
     * Is the class (or object) supported by this registry
     *
     * @param string|object $class     Class or object to be checked
     * @param null|string   $objectKey To refine search
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function isSupported($class, $objectKey = null);

    /**
     * Is object key supported by this registry
     *
     * @param string $objectKey Object key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function isSupportedKey($objectKey);

    /**
     * Get expected type for an object key
     *
     * This will return the class or interface that inherit or implement to register to an $objectKey
     *
     * @param string $objectKey Object key
     *
     * @return string
     * @throws ObjectKeyNotSupportedException
     * @throws InvalidArgumentException
     */
    public static function getExpectedType($objectKey);

    /**
     * Get the object classes or interfaces that this registry supports
     *
     * @return array|string[] An array with object keys (identifiers) as keys and their respective classes/interfaces
     *                        as values. The returned classes/interfaces must be extended/implemented by objects that
     *                        are registering to that key in this registry.
     */
    public static function getSupportedTypes();
}
