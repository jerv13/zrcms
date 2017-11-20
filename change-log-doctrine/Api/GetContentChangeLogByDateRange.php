<?php

namespace Zrcms\ChangeLogDoctrine\Api;

interface GetContentChangeLogByDateRange
{
    public function __invoke(\DateTime $stateDate, \DateTime $endDate);
}
