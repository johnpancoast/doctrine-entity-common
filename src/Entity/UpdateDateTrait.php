<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Date trait
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait UpdateDateTrait
{
    /**
     * @var \DateTime
     */
    protected $createDate;

    /**
     * @var \DateTime
     */
    protected $updateDate;

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
     * @return $this
     */
    public function setUpdateDate(\DateTime $date)
    {
        $this->updateDate = $date;
        return $this;
    }
}