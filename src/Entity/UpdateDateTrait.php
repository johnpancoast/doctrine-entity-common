<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author        John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Update (and create) date behavior
 *
 * This implements behavior in UpdateDateInterface
 *
 * @see    UpdateDateInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait UpdateDateTrait
{
    use UpdateDateNoPropTrait;

    /**
     * @var \DateTime
     */
    protected $createDate;

    /**
     * @var \DateTime
     */
    protected $updateDate;
}