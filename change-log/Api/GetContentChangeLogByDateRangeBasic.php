<?php

namespace Zrcms\ChangeLog\Api;

use Interop\Container\ContainerInterface;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;

class GetContentChangeLogByDateRangeBasic implements GetChangeLogByDateRange
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

        usort($changeLogEvents, function (ChangeLogEvent $a, ChangeLogEvent $b) {
            return $a->getDateTime() < $b->getDateTime();
        });

        return $changeLogEvents;
    }



    public function addSubordinate(GetChangeLogByDateRange $getChangeLogByDateRange)
    {
        $this->subordanites[] = $getChangeLogByDateRange;
    }
}
