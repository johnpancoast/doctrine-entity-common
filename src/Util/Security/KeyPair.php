<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util\Security;

/**
 * Immutable key pair
 *
 * This simply holds data of a key pair. How they were created is outside of the scope.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class KeyPair
{
    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * Constructor
     *
     * @param string $publicKey
     * @param string $privateKey
     */
    final public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * Get publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Get privateKey
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }
}
