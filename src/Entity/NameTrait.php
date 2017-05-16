<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author        John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Name behavior
 *
 * This implements the behavior in NameInterface
 *
 * @see    NameInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait NameTrait
{
    use NameNoPropTrait;

    /**
     * @var string
     */
    protected $name;
}
