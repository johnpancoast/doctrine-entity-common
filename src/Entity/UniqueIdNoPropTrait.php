<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Unique id trait
 *
 * This implements the behavior in UniqueIdInterface and is useful for cases where getting errors about mapping trait
 * properties in your ORM (ahem, doctrine).
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait UniqueIdNoPropTrait
{
    //protected $uuid;

    /**
     * Set unique id
     *
     * @param string|int $id
     *
     * @return $this
     */
    public function setUniqueId($id)
    {
        $this->uuid = $id;

        return $this;
    }

    /**
     * @return string|int
     */
    public function getUniqueId()
    {
        return $this->uuid;
    }
}
