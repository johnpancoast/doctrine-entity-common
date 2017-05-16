<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author        John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Date range behavior
 *
 * This implements DateRangeInterface.
 *
 * @see    DateRangeInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DateRangeTrait
{
    use DateRangeNoPropTrait;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;
}