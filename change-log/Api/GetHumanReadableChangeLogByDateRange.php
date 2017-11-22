<?php


namespace Zrcms\ChangeLog\Api;


use Zrcms\Content\Api\GetChangeLogByDateRange;

class GetHumanReadableChangeLogByDateRange
{
    protected $getChangeLogByDateRange;
    protected $changeLogEventToString;

    public function __construct(
        GetChangeLogByDateRange $getChangeLogByDateRange,
        ChangeLogEventToString $changeLogEventToString
    ) {
        $this->getChangeLogByDateRange = $getChangeLogByDateRange;
        $this->changeLogEventToString = $changeLogEventToString;
    }

    public function __invoke(\DateTime $greaterThanYear, \DateTime $lessThanYear)
    {
        $humanReadableEvents = [];
        foreach ($this->getChangeLogByDateRange->__invoke($greaterThanYear, $lessThanYear) as $changeLogEvent) {
            $humanReadableEvents[] = [
                'date' => $changeLogEvent->getDateTime()->format('c'),
                'description' => $this->changeLogEventToString->__invoke($changeLogEvent)
            ];
        }

        return $humanReadableEvents;
    }
}
