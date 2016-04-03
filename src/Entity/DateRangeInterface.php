<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entity date ranges
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface DateRangeInterface
{
    /**
     * Get start date
     *
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * Set start date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setStartDate(\DateTime $date);

    /**
     * Get end date
     *
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * Set end date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setEndDate(\DateTime $date);
}
