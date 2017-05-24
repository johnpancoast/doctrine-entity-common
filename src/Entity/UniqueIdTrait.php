<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */


namespace Pancoast\Common\Entity;

/**
 * Unique id trait
 *
 * This implements the behavior in UniqueIdInterface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait UniqueIdTrait
{
    use UniqueIdNoPropTrait;

    /**
     * @var string
     */
    protected $uuid;
}