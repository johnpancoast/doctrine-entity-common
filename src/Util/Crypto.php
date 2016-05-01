<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

use Pancoast\Common\Exception\InvalidHashingAlgorithmException;
use Pancoast\Common\Exception\SystemCryptoException;
use Pancoast\Common\Util\Crypto\MessageSignature;

/**
 * Crypto utilities
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Crypto implements CryptoInterface
{
    /**
     * @var string Private key
     */
    private $privateKey;

    /**
     * @var int How many times will we attempt to make a cryptographically strong string of bytes.
     */
    private $strongCryptoAttempts;

    /**
     * @var int Default byte length when none specified.
     *
     * This should probably be at least 64 to mean 512 bits of random data.
     */
    private $defaultRandomByteLength;

    /**
     * @var string Default hashing algorithm mainly for calls to {@see self::generateHmac()}.
     *
     * One of the self::HASH_ALGO_* constants
     */
    private $defaultHashingAlgo;

    /**
     * Hashing algorithms
     *
     * @todo Add others as needed and add to self::getHashingAlgos().
     */
    const HASH_ALGO_SHA256 = 'sha256';

    /**
     * Constructor
     *
     * @param string $privateKey              Private key used for crypto, digital signing
     * @param int    $strongCryptoAttempts    How many times we try to create a cryptograhpically strong token.
     * @param int    $defaultRandomByteLength Default byte length for random strings
     * @param string $defaultHashingAlgo      Default hashing algorithm mainly for calls to {@see self::generateHmac()}.
     */
    public function __construct(
        $privateKey,
        $strongCryptoAttempts,
        $defaultRandomByteLength,
        $defaultHashingAlgo
    )
    {
        if (!is_int($strongCryptoAttempts)) {
            throw new \InvalidArgumentException('$strongCrypto attempts must be of type int');
        }

        if (!is_int($defaultRandomByteLength)) {
            throw new \InvalidArgumentException('$defaultRandomByteLength attempts must be of type int');
        }

        $this->validateHashingAlgo($defaultHashingAlgo);

        $this->privateKey = $privateKey;
        $this->strongCryptoAttempts = $strongCryptoAttempts;
        $this->defaultRandomByteLength = $defaultRandomByteLength;
        $this->defaultHashingAlgo = $defaultHashingAlgo;
    }

    /**
     * @inheritDoc
     */
    public function generateHmac($data, $hashingAlgo = null)
    {
        return hash_hmac($hashingAlgo ?: $this->defaultHashingAlgo, $data, $this->privateKey);
    }

    /**
     * @inheritDoc
     */
    public function generateMessageSignature($message = null)
    {
        return new MessageSignature($message ?: $this->generateSecureRandomHex(16), $this);
    }

    /**
     * @inheritDoc
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomBase64($byteLength = null)
    {
        return base64_encode($this->generateSecureRandomBytes($byteLength));
    }

    /**
     * @inheritDoc
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomHex($byteLength = null)
    {
        return bin2hex($this->generateSecureRandomBytes($byteLength));
    }

    /**
     * @inheritDoc
     * @see self::DEFAULT_RANDOM_BYTE_LENGTH
     * @see self::STRONG_CRYPTO_ATTEMPTS
     */
    public function generateSecureRandomBytes($byteLength = null)
    {
        $attempts = 0;
        $cryptoStrong = false;
        do {
            // TODO when php7 is common, consider using http://php.net/random_bytes instead
            $bytes = openssl_random_pseudo_bytes($byteLength ?: $this->defaultRandomByteLength, $cryptoStrong);
            ++$attempts;
        } while (!$cryptoStrong && $attempts < self::STRONG_CRYPTO_ATTEMPTS);

        if (!$cryptoStrong) {
            throw new SystemCryptoException();
        }

        return $bytes;
    }

    /**
     * @inheritDoc
     */
    public static function getHashingAlgos()
    {
        return [
            self::HASH_ALGO_SHA256
        ];
    }

    /**
     * Validate hashing algorithm
     *
     * @param string $hashingAlgo
     *
     * @throws \InvalidArgumentException If unexpected hashing algorithm.
     */
    private function validateHashingAlgo($hashingAlgo)
    {
        if (!in_array($hashingAlgo, self::getHashingAlgos())) {
            throw new \InvalidArgumentException(sprintf('Unexpected hashing algorithm "%s"', $hashingAlgo));
        }
    }
}
