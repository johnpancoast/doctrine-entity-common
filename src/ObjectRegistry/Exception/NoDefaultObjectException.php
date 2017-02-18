<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry\Exception;

/**
 * When a default object was attempted to be registered and no default available
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class NoDefaultObjectException extends \LogicException
{
}
