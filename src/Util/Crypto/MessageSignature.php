<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util\Crypto;

/**
 * Immutable message signature
 *
 * This simply represents a message and its signature. How they were created and their validity are outside the scope of
 * this class
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
     * @param string $message
     * @param string $signature
     */
    final public function __construct($message, $signature)
    {
        $this->message = $message;
        $this->signature = $signature;
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
