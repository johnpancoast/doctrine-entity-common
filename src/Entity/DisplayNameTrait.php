<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */


namespace Pancoast\Common\Entity;

/**
 * Display name beheavior
 *
 * This implements DisplayNameInterface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DisplayNameTrait
{
    /**
     * @var string
     */
    protected $displayName;

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }
}
