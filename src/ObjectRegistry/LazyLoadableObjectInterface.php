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
     * @param string $objectKey Object key that the implementation of this class was registered to in the repository.
     *
     * @return object
     */
    public function loadObject($objectKey);
}
