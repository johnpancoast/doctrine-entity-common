<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util\Crypto;

use Pancoast\Common\Util\CryptoInterface;

/**
 * Immutable message signature
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class MessageSignature
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $signature;

    /**
     * Constructor
     *
     * @param                 $message Message you're creating signature for
     * @param CryptoInterface $crypto class used to create the signature
     */
    public function __construct($message, CryptoInterface $crypto)
    {
        $this->message = $message;
        $this->signature = $crypto->generateHmac($message);
    }

    /**
     * Get publicKey
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get privateKey
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
