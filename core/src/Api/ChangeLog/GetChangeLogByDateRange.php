<?php

namespace Zrcms\Core\Api\ChangeLog;

/**
 * @author Rod McNew
 */
interface GetChangeLogByDateRange
{
    /**
     * Important - Implementors of this interface do not have to return the events in any order. Its up to the caller
     * to sort them after calling this function.
     *
     * @param \DateTime $greaterThanDate
     * @param \DateTime $lessThanDate
     * @return array of ChangeLogEvent
     */
    public function __invoke(\DateTime $greaterThanDate, \DateTime $lessThanDate): array;
}
