<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */


namespace Pancoast\Common\Entity;

/**
 * Identifier behavior
 *
 * This implements IdInterface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait IdTrait
{
    use IdNoPropTrait;

    /**
     * @var mixed
     */
    protected $id;
}
