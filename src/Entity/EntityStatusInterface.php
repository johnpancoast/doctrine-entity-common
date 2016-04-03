<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Pancoast\Common\Entity\EntityStatusInterface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface EntityStatusInterface
{
    /**
     * Set status
     *
     * @param string $status One of the {@see Status} constants.
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get status
     * @return string
     */
    public function getStatus();
}