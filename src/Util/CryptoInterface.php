<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

/**
 * Contract for crypto classes
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface CryptoInterface
{
    /**
     * Generate an hmac
     *
     * @param string      $message     Data to generate hmac for
     * @param string|null $hashingAlgo One of the values from self::getHashingAlgos(). If null, an implementation
     *                                 default will be used.
     *
     * @return string
     * @see https://en.wikipedia.org/wiki/Hash-based_message_authentication_code
     */
    public function generateHmac($message, $hashingAlgo = null);

    /**
     * Generate a key pair
     *
     * @param string|null $message If null, this will be created automatically.
     *
     * @return MessageSignature
     * @throws SystemCryptoException If $message not supplied and strong crypto was not available on the system.
     */
    public function generateMessageSignature($message = null);

    /**
     * Generate cryptographically secure (pseudo) random bytes to a certain byte length
     *
     * @param int $byteLength = null Length (in bytes) of binary data. If null, an implementation default will be used
     *
     * @return string Binary data
     * @throws SystemCryptoException If strong crypto was not available on the system.
     */
    public function generateRandomBytes($byteLength = null);

    /**
     * @return array Get supported hashing algos
     */
    public static function getHashingAlgos();
}
