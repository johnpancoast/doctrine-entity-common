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
     * @param string      $data        Data to generate hmac for
     * @param string|null $hashingAlgo One of the values from self::getHashingAlgos(). If null, an implementation
     *                                 default will be used.
     *
     * @return string
     * @see https://en.wikipedia.org/wiki/Hash-based_message_authentication_code
     */
    public function generateHmac($data, $hashingAlgo = null);

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
     * Generate cryptographically secure (pseudo) random base64 encoded string using bytelength
     *
     * Note that the resulting string will be longer than $byteLength due to conversion
     *
     * @param int|null $byteLength Length (in bytes) of binary data. If null, an implementation default will be used.
     *
     * @return string Base64 encoded string of binary data up to $byteLength
     * @throws SystemCryptoException If strong crypto was not available on the system.
     */
    public function generateSecureRandomBase64($byteLength = null);

    /**
     * Generate cryptographically secure (pseudo) random hex using bytelength
     *
     * Note that the resulting string will be longer than $byteLength due to conversion
     *
     * @param int|null $byteLength Length (in bytes) of binary data. If null, an implementation default will be used.
     *
     * @return string Hex representation of binary data up to $byteLength
     * @throws SystemCryptoException If strong crypto was not available on the system.
     */
    public function generateSecureRandomHex($byteLength = null);

    /**
     * Generate cryptographically secure (pseudo) random bytes to a certain byte length
     *
     * @param int|null $byteLength Length (in bytes) of binary data. If null, an implementation default will be used
     *
     * @return string Binary data
     * @throws SystemCryptoException If strong crypto was not available on the system.
     */
    public function generateSecureRandomBytes($byteLength = null);

    /**
     * @return array Get available hashing algos mainly used for calls to {@see self::generateHmac()}.
     */
    public static function getHashingAlgos();
}
