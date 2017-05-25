<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Date range behavior
 *
 * This implements DateRangeInterface and is useful for cases where doctrine is erroring on mapping trait properties.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DateRangeNoPropTrait
{
    //protected $startDate;
    //protected $endDate;

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
     *
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
     *
     * @return $this
     */
    public function setEndDate(\DateTime $date = null)
    {
        if (!$date) {
            $date = $this->getDefaultDate();

            if (!$date instanceof \DateTime) {
                throw new \RuntimeException("Expected valid datetime for default date");
            }
        }

        $this->endDate = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDefaultDate()
    {
        return new \DateTime();
    }
}
