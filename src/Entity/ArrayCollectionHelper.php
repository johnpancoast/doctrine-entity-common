<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Util\Exception\InvalidTypeArgumentException;
use Pancoast\Common\Util\Util;

/**
 * A general helper for entities using doctrine common's ArrayCollection
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ArrayCollectionHelper
{
    /**
     * Get ArrayCollection from different types of traversable $elements
     *
     * @param array|ArrayCollection $elements Array or ArrayCollection to build collection from.
     *
     * @return ArrayCollection
     * @throws InvalidArgumentException     If $elements not array or instance of ArrayCollection
     */
    public function getCollection($elements)
    {
        // validate that $elements is either an array or ArrayCollection.
        // turn array into ArrayCollection.
        if (is_array($elements)) {
            $elements = new ArrayCollection($elements);
        } elseif (!$elements instanceof ArrayCollection) {
            throw new InvalidArgumentException(
                sprintf(
                    '$elements must be an array or an instance of %s, but was of type %s', ArrayCollection::class,
                    gettype($elements)
                )
            );
        }

        return $elements;
    }

    /**
     * Get validated ArrayCollection from different types of traversable $elements
     *
     * @param array|ArrayCollection $elements Array or ArrayCollection to build collection from.
     * @param bool|mixed|array      $type     A type or array of types of which each element must match
     *
     * @return ArrayCollection
     * @throws InvalidTypeArgumentException If the type you passed isn't a valid type to check against
     * @throws InvalidArgumentException     If $element or any of its elemtns are of the wrong type
     */
    public function getValidatedCollection($elements, $type)
    {
        return (new Util())->getValidatedValue($this->getCollection($elements), $type);
    }
}
