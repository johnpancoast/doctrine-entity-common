<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Exception;

/**
 * Occurs when a system cannot generate cryptographically secure bytes
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class SystemCryptoException extends \Exception
{
    protected $message = 'System could not generate cryptographically secure random bytes';
}
