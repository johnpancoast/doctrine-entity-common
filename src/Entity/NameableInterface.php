<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * A contract for an entity that has a name and string representation
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface NameableInterface
{
    /**
     * @param string $title
     * @return object Instance of current entity after setting title
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string Representation of object as a string
     */
    public function __toString();
}