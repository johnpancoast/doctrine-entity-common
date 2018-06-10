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
     * @param string $firstName
     *
     * @return static
     */
    public function setFirstName($firstName);

    /**
     * Get person's middle name
     *
     * @return string
     */
    public function getMiddleName();

    /**
     * Set person's middle name
     *
     * @param string $middleName
     *
     * @return static
     */
    public function setMiddleName($middleName);

    /**
     * Get person's last name
     *
     * @return mixed
     */
    public function getLastName();

    /**
     * Set person's last name
     *
     * @param string $lastName
     *
     * @return static
     */
    public function setLastName($lastName);

    /**
     * Get person's surname
     *
     * Alias of self::getLastName()
     *
     * @see HumanNameInterface::getLastName()
     * @return string
     */
    public function getSurname();

    /**
     * Set person's surname
     *
     * Alias of self::setLastName()
     *
     * @see HumanNameInterface::setLastName()
     * @return mixed
     */
    public function setSurname($surname);
}
