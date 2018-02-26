<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2018 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities that have a time range in a day
 *
 * A day time range is similar to a standard time range but allows you to specify if range is all day.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface DayTimeRangeInterface extends TimeRangeInterface
{
    /**
     * Set if range is all day
     *
     * @param bool $allDay
     *
     * @return static
     */
    public function setAllDay($allDay);

    /**
     * Is all day
     *
     * To allow implementations to have null values, we allow null to be returned which should be considered equivalent
     * to false.
     *
     * @return bool|null
     */
    public function isAllDay();
}
