<?php
/**
 * @package johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\Common\Entity;

/**
 * Statuses
 *
 * Not implementation of anything
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Status
{
    const ENABLED = 'enabled';
    const DISABLED = 'disabled';

    /**
     * Get status constants
     *
     * @return array
     */
    public static function getStatuses()
    {
        // keep this up to date with the above statuses, dude(tte)s
        return [
            self::ENABLED,
            self::DISABLED,
        ];
    }
}
