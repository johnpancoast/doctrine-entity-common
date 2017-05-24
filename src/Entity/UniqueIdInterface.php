<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Contract for entities that have a unique identifier
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface UniqueIdInterface
{
    /**
     * Get unique id
     *
     * @return string
     */
    public function getUniqueId();

    /**
     * Set unique id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setUniqueId($id);
}
