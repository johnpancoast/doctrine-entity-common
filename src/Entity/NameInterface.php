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
     * @param string $title
     * @return object Instance of current entity after setting title
     */
    public function setName($title);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string Representation of object as a string
     */
    public function __toString();
}
