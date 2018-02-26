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
 * Only hour and minute properties are relevant for \DateTime objects.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface TimeRangeInterface
{
    /**
     * Get start time
     *
     * @return \DateTime
     */
    public function getStartTime();

    /**
     * Set start time
     *
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime);

    /**
     * Get end time
     *
     * @return \DateTime
     */
    public function getEndTime();

    /**
     * Set start time
     *
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime);
}
