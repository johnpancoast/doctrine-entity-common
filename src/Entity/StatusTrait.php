<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;
use Pancoast\Common\Entity\Status;

/**
 * Pancoast\Common\Entity\StatusTrait
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait StatusTrait
{
    /**
     * @var string One of the {@see Status} constants
     */
    protected $status;

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        if (!in_array($status, Status::getStatuses(), true)) {
            throw new \LogicException('$status must be one of the BaseBundle\Entity\Status constants');
        }

        $this->status = $status;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->status;
    }
}