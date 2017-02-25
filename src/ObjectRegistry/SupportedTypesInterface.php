<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectNotSupportedException;

/**
 * Simple config object of supported types for an object registry
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface SupportedTypesInterface
{
    /**
     * Key that default types live under
     */
    const KEY_DEFAULTS = 'defaults';

    /**
     * Add supported type
     *
     * @param string      $class     Class or interface of which object registries registering to this object key must
     *                               match
     * @param null|string $objectKey Object key that the supported type must be registered to.
     *
     * @return SupportedTypesInterface|self
     */
    public function add($class, $objectKey);

    //    Will be added soon
    //    /**
    //     * Remove supported type
    //     *
    //     * @param string $class Class or interface
    //     *
    //     * @return SupportedTypesInterface|self
    //     */
    //    public function remove($class);
    //
    //    /**
    //     * Remove supported type by key
    //     *
    //     * @param $objectKey
    //     *
    //     * @return SupportedTypesInterface|self
    //     */
    //    public function removeKey($objectKey);

    /**
     * Add a default supported type (class or interface)
     *
     * When checking if a type is supported, defaults are checked for all classes.
     *
     * @param string $class Class or interface
     *
     * @return SupportedTypesInterface|self
     * @throws \Pancoast\Common\Exception\InvalidArgumentException
     */
    public function addDefault($class);

    /**
     * @param array $classes Default classes or interfaces
     *
     * @return SupportedTypesInterface|self
     */
    public function addDefaults(array $classes);

    /**
     * Get supported default types
     *
     * @return array
     */
    public function getDefaults();

    /**
     * Get supported types by object key
     *
     * @param null|string $objectKey
     *
     * @return array
     * @throws \Pancoast\Common\Exception\InvalidArgumentException
     */
    public function get($objectKey = null);

    /**
     * Get all supported types including keys and defaults
     *
     * @return array
     */
    public function getAll();

    /**
     * Is the class/object (and optional key) supported by the object registry
     *
     * If $objectKey not set, class will be checked against all types including defaults.
     *
     * @param string|object $object    Class or object
     * @param null|string   $objectKey Can specify a supported key or 'defaults' for a default type to match $class to
     *                                 or null to match $class to any type including defaults.
     *
     * @return bool
     * @throws \Pancoast\Common\Exception\InvalidArgumentException
     */
    public function isSupported($object, $objectKey = null);

    /**
     * Is object key supported
     *
     * Note that if there are defaults available, this will return true since an object can register to any key as long
     * as it matches a default.
     *
     * @param string $objectKey Specific object key or self::KEY_DEFAULTS
     *
     * @return bool
     * @throws \Pancoast\Common\Exception\InvalidArgumentException
     */
    public function isSupportedKey($objectKey);

    /**
     * Validate an object's type against supported types
     *
     * This is similar to self::isSupported() but throws exceptions
     *
     * @param string|object $object    Class or object
     * @param string        $objectKey Supported key to check
     * @throws \Pancoast\Common\ObjectRegistry\Exception\ObjectNotSupportedException
     * @throws \Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException
     * @throws \Pancoast\Common\Exception\InvalidArgumentException
     */
    public function validate($object, $objectKey);
}
