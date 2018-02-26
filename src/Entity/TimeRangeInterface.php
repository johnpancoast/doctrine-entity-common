<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2018 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities that have a time range
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface TimeRangeInterface
{
    /**
     * Get start time
     *
     * Format will be 'hh:mm'
     *
     * @return string
     */
    public function getStartTime();

    /**
     * Set start time
     *
     * Accepts format 'hh:mm'
     *
     * @return string
     */
    public function setStartTime();

    /**
     * Get end time
     *
     * Format will be 'hh:mm'
     *
     * @return string
     */
    public function getEndTime();

    /**
     * Set start time
     *
     * Accepts format 'hh:mm'
     *
     * @return string
     */
    public function setEndTime();
}
