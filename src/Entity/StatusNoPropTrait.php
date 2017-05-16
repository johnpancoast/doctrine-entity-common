<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Status behavior
 *
 * This implements StatusInterface and is useful for cases where doctrine is erroring on mapping trait properties.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait StatusNoPropTrait
{
    //protected $status;

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