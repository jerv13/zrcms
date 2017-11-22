<?php

namespace Zrcms\ChangeLog\Api;

use Zrcms\Content\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Content\Model\ChangeLogEvent;

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
