<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Display name behavior
 *
 * This implements DisplayNameInterface and is useful for cases where doctrine is erroring on mapping trait properties
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DisplayNameNoPropTrait
{
    //protected $displayName;

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }
}
