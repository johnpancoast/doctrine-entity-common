<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author        John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Status behavior
 *
 * This implements StatusInterface
 *
 * @see    StatusInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait StatusTrait
{
    use StatusNoPropTrait;

    /**
     * @var string One of the {@see Status} constants
     */
    protected $status;
}
