<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities that have a name
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface NameInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return static
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();
}
