<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

/**
 * Simple config object of supported types for an object registry
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface SupportedTypesInterface
{
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
     * Add a default supported type
     *
     * When checking if a type is supported, defaults are checked for all classes.
     *
     * @param string $class Class or interface
     *
     * @return SupportedTypesInterface|self
     */
    public function addDefault($class);

    /**
     * Get supported default types
     *
     * @return array
     */
    public function getDefaults();

    /**
     * Get supported type by object key
     *
     * @param string $objectKey
     *
     * @return string
     */
    public function get($objectKey);

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
     * @internal param object|string $class
     */
    public function isSupported($object, $objectKey = null);

    /**
     * Is object key supported
     *
     * @param string $objectKey Specific object key or 'defaults'
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isSupportedKey($objectKey);
}
