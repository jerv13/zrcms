<?php

namespace Zrcms\CoreApplication\Api\ChangeLog;

use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Core\Model\ChangeLogEvent;

class GetContentChangeLogComposite implements GetChangeLogByDateRange
{
    protected $subordanites;

    public function __invoke(\DateTime $greaterThanDate, \DateTime $lessThanDate): array
    {
        $changeLogEvents = [];

        /**
         * @var $subordanite GetChangeLogByDateRange
         */
        foreach ($this->subordanites as $subordanite) {
            $changeLogEvents = array_merge(
                $subordanite->__invoke($greaterThanDate, $lessThanDate),
                $changeLogEvents
            );
        }

        //Sort the items by date descending
        usort(
            $changeLogEvents,
            function (ChangeLogEvent $a, ChangeLogEvent $b) {
                return $a->getDateTime() < $b->getDateTime();
            }
        );

        return $changeLogEvents;
    }

    public function addSubordinate(GetChangeLogByDateRange $getChangeLogByDateRange)
    {
        $this->subordanites[] = $getChangeLogByDateRange;
    }
}
