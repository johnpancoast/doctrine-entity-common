<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

use Pancoast\Common\Exception\SystemCryptoException;

/**
 * Security utilities
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Security
{
    /**
     * @var string Private key *Do not provide getter or outside/child access*
     */
    private $privateKey;

    /**
     * How many times will we attempt to make a cryptographically strong string of bytes
     */
    const STRONG_CRYPTO_ATTEMPTS = 10;

    /**
     * Default byte length when none specified
     *
     * 32 bytes * 8 = 512 bits of (pseudo) random data which should be secure enough.
     */
    const DEFAULT_RANDOM_BYTE_LENGTH = 32;

    /**
     * Hashing algorithms
     * @todo Add others as needed
     */
    const HASH_ALGO_SHA256 = 'sha256';

    /**
     * Constructor
     *
     * @param string $privateKey
     */
    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * Generate an hmac
     *
     * @param null|string $data The data to hash. If null provided, random data will be generated.
     * @param string      $hashingAlgo
     *
     * @return string
     * @throws SystemCryptoException If strong crypto was not available on the system.
     * @see https://en.wikipedia.org/wiki/Hash-based_message_authentication_code
     */
    public function generateHmac($data = null, $hashingAlgo = self::HASH_ALGO_SHA256)
    {
        return hash_hmac($hashingAlgo, $data ?: $this->generateSecureRandomBytes(), $this->privateKey);
    }

    /**
     * Generate cryptographically secure (pseudo) random base64 encoded string using bytelength
     *
     * Note that the resulting string will be longer than $byteLength due to conversion
     *
     * @param int|null $byteLength Length (in bytes) of binary data. If null passed then this defaults to {@see
     *                         self::DEFAULT_RANDOM_BYTE_LENGTH}.
     *
     * @return string Base64 encoded string of binary data up to $byteLength
     * @throws SystemCryptoException If strong crypto was not available on the system.
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomBase64($byteLength = self::DEFAULT_RANDOM_BYTE_LENGTH)
    {
        return base64_encode($this->generateSecureRandomBytes($byteLength));
    }

    /**
     * Generate cryptographically secure (pseudo) random hex using bytelength
     *
     * Note that the resulting string will be longer than $byteLength due to conversion
     *
     * @param int|null $byteLength Length (in bytes) of binary data. If null passed then this defaults to {@see
     *                         self::DEFAULT_RANDOM_BYTE_LENGTH}.
     *
     * @return string Hex representation of binary data up to $byteLength
     * @throws SystemCryptoException If strong crypto was not available on the system.
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomHex($byteLength = self::DEFAULT_RANDOM_BYTE_LENGTH)
    {
        return bin2hex($this->generateSecureRandomBytes($byteLength));
    }

    /**
     * Generate cryptographically secure (pseudo) random bytes to a certain byte length
     *
     * @param int|null $length Length (in bytes) of binary data. If null passed then this defaults to {@see
     *                         self::DEFAULT_RANDOM_BYTE_LENGTH}.
     *
     * @return string Binary data
     * @throws SystemCryptoException If strong crypto was not available on the system.
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomBytes($length = self::DEFAULT_RANDOM_BYTE_LENGTH)
    {
        $attempts = 0;
        $cryptoStrong = false;
        do {
            // TODO when php7 is common, consider using http://php.net/random_bytes instead
            $bytes = openssl_random_pseudo_bytes($length, $cryptoStrong);
            ++$attempts;
        } while (!$cryptoStrong && $attempts < self::STRONG_CRYPTO_ATTEMPTS);

        if (!$cryptoStrong) {
            throw new SystemCryptoException();
        }

        return $bytes;
    }
}
