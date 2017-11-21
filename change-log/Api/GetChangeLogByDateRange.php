<?php

namespace Zrcms\ChangeLog\Api;

interface GetChangeLogByDateRange
{
    /**
     * Important - Implementors of this interface to not have to return the events in an order. Its up to the caller
     * to sort them after calling this function.
     *
     * @param \DateTime $greaterThanDate
     * @param \DateTime $lessThanDate
     * @return array of ChangeLogEvent
     */
    public function __invoke(\DateTime $greaterThanDate, \DateTime $lessThanDate): array;
}