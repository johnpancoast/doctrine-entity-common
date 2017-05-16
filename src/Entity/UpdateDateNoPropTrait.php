<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */


namespace Pancoast\Common\Entity;

/**
 * Update (and create) date behavior
 *
 * This implements behavior in UpdateDateInterface and is useful for cases where doctrine is erroring on mapping trait
 * properties.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait UpdateDateNoPropTrait
{
    //protected $createDate;
    //protected $updateDate;

    /**
     * Get create date
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set create date
     *
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setCreateDate(\DateTime $date)
    {
        $this->createDate = $date;

        return $this;
    }

    /**
     * Get update date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set update date
     *
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setUpdateDate(\DateTime $date)
    {
        $this->updateDate = $date;

        return $this;
    }
}
