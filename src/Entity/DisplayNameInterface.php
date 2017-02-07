<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities who have a display name
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface DisplayNameInterface
{
    /**
     * Set display name
     *
     * @param string $displayName
     *
     * @return $this
     */
    public function setDisplayName($displayName);

    /**
     * Get display namae
     *
     * @return string
     */
    public function getDisplayName();
}
