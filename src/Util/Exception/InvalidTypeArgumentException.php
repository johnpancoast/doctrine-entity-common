<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util\Exception;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Util\Validator;

/**
 * Thrown when Util determines that the developer is checking invalid type
 *
 * @see    Validator
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class InvalidTypeArgumentException extends InvalidArgumentException
{
}
