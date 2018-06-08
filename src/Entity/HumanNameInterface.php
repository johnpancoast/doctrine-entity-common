<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2018 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Human name interface
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface HumanNameInterface
{
    /**
     * Get person's first name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set person's first name
     *
     * @return string
     */
    public function setFirstName();

    /**
     * Get person's middle name
     *
     * @return string
     */
    public function getMiddleName();

    /**
     * Set person's middle name
     *
     * @return string
     */
    public function setMiddleName();

    /**
     * Get person's last name
     *
     * @return mixed
     */
    public function getLastName();

    /**
     * Set person's last name
     *
     * @return mixed
     */
    public function setLastName();

    /**
     * Get person's surname
     *
     * MUST return same as self::getLastName()
     *
     * @return mixed
     */
    public function getSurname();

    /**
     * Set person's surname
     *
     * MUST set same as self::setLastName()
     *
     * @return mixed
     */
    public function setSurname();
}
