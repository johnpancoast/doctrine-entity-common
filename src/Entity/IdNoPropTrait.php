<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2015-2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Id behavior
 *
 * This implements IdInterface and is useful for cases where doctrine is erroring on mapping trait properties
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait IdNoPropTrait
{
    //protected $id;

    /**
     * Get identifier
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
