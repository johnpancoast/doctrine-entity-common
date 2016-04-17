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
 * Status behavior
 *
 * This implements StatusInterface
 *
 * @see StatusInterface
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
        if (!$this->isValidStatus($status)) {
            throw new \LogicException(sprintf('Invalid status "%s"', $status));
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

    /**
     * @param $status
     *
     * @return bool
     */
    public function isValidStatus($status)
    {
        return in_array($status, Status::getStatuses(), true);
    }
}
