<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Date range behavior
 *
 * This implements DateRangeInterface.
 *
 * @see DateRangeInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DateRangeTrait
{
    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * Get start date
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set start date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setStartDate(\DateTime $date)
    {
        $this->startDate = $date;
        return $this;
    }

    /**
     * Get end date
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set end date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setEndDate(\DateTime $date = null)
    {
        $this->endDate = $date ?: new \DateTime('1900-01-01 00:00:00');
        return $this;
    }
}