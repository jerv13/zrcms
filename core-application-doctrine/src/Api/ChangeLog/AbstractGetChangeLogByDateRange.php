<?php

namespace Zrcms\CoreApplicationDoctrine\Api\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Core\Model\ChangeLogEvent;

/**
 * @author Rod McNew
 */
abstract class AbstractGetChangeLogByDateRange implements GetChangeLogByDateRange
{
    protected $entityManger;

    abstract protected function getResourceHistoryEntityName(): string;

    abstract protected function getVersionEntityName(): string;

    abstract protected function versionRowToChangeLogEvent($version): ChangeLogEvent;

    abstract protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManger = $entityManager;
    }

    public function __invoke(\DateTime $greaterThanDate, \DateTime $lessThanDate): array
    {
        $changeLogEvents = [];

        foreach ($this->getVersionRows($greaterThanDate, $lessThanDate) as $row) {
            $changeLogEvents[] = $this->versionRowToChangeLogEvent($row);
        }

        foreach ($this->getResourceHistoryRows($greaterThanDate, $lessThanDate) as $row) {
            $changeLogEvents[] = $this->resourceHistoryRowToChangeLogEvent($row);
        }

        return $changeLogEvents;
    }

    protected function getVersionRows(\DateTime $greaterThanDate, \DateTime $lessThanDate)
    {
        $resourceRepo = $this->entityManger->getRepository($this->getVersionEntityName());

        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('createdDateObject', $greaterThanDate));
        $criteria->andWhere($criteria->expr()->lt('createdDateObject', $lessThanDate));

        $results = $resourceRepo->matching($criteria);

        return $results;
    }

    protected function getResourceHistoryRows(\DateTime $greaterThanDate, \DateTime $lessThanDate)
    {
        $resourceRepo = $this->entityManger->getRepository($this->getResourceHistoryEntityName());

        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('createdDateObject', $greaterThanDate));
        $criteria->andWhere($criteria->expr()->lt('createdDateObject', $lessThanDate));

        $results = $resourceRepo->matching($criteria);

        return $results;
    }
}
