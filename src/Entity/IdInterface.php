<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities who have an identifier
 *
 * Entities typically don't have a setter for this so we leave it off.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface IdInterface
{
    /**
     * Get identifier
     *
     * @return mixed
     */
    public function getId();
}
