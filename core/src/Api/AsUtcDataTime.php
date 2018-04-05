<?php

namespace Zrcms\Core\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AsUtcDataTime
{
    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTime
     */
    public static function invoke(\DateTime $dateTime): \DateTime
    {
        $timezone = new \DateTimeZone('UTC');
        $utcDateOffset = $dateTime->getOffset();
        $utcDateTime = clone($dateTime);
        $utcDateTime->setTimezone($timezone);
        $sign = ($utcDateOffset < 0 ? '-' : '+');
        $offsetStr = '' . abs($utcDateOffset);
        $modifyString = $sign . $offsetStr.' seconds';
        $utcDateTime->modify($modifyString);

        return $utcDateTime;
    }
}
