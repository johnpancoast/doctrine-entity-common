<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Name behavior
 *
 * This implements NameInterface and is useful for cases where doctrine is erroring on mapping trait properties.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait NameNoPropTrait
{
    //protected $name;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}