<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Name behavior
 *
 * This implements the behavior in NameInterface
 *
 * @see NameInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait NameTrait
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @inheritDoc
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $title = $this->getTitle();
        return $title ?: '';
    }
}
