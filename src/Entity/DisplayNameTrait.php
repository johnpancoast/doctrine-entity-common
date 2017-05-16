<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Display name behavior
 *
 * This implements DisplayNameInterface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DisplayNameTrait
{
    use DisplayNameNoPropTrait;

    /**
     * @var string
     */
    protected $displayName;
}
