<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry\Exception;

/**
 * When interacting with lazy load methods on a key that's not lazy loadable
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class NotLazyLoadableKeyException extends \Exception
{
}