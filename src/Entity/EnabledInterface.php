<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities that have ability to be enabled or disabled
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface EnabledInterface
{
    /**
     * Is this entity enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get enabled
     *
     * This should return the same as to self::isEnabled()
     *
     * @return bool
     */
    public function getEnabled();

    /**
     * Set enabled
     *
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled);

    /**
     * Enable this entity
     *
     * This is equivalent to calling self::setEnabled(true)
     *
     * @return $this
     */
    public function enable();

    /**
     * Disable this entity
     *
     * This is equivalent to calling self::setEnabled(false)
     *
     * @return $this
     */
    public function disable();
}
