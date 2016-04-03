<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Entity contract for update (and create) dates
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface UpdateDateInterface
{
    /**
     * Get create date
     *
     * @return \DateTime
     */
    public function getCreateDate();

    /**
     * Set create date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setCreateDate(\DateTime $date);

    /**
     * Get update date
     *
     * @return \DateTime
     */
    public function getUpdateDate();

    /**
     * Set update date
     *
     * @param \DateTime $date
     * @return mixed
     */
    public function setUpdateDate(\DateTime $date);
}