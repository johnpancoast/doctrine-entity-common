<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

/**
 * Contract for lazy loadable objects
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface LazyLoadableObjectInterface
{
    /**
     * Create and return object
     *
     * Although your implementation can cache the object to be sure, at the moment it's not necessary since object
     * registries will load the object only once.
     *
     * @param string $objectKey
     *
     * @return object
     */
    public function loadObject($objectKey);
}
