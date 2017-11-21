<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\ChangeLog\Api\ChangeLogEvent;
use Zrcms\Content\Model\ActionCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;

class GetChangeLogByDateRange implements \Zrcms\ChangeLog\Api\GetChangeLogByDateRange
{
    protected $entityManger;

    protected $resourceHistoryEntityName;

    protected $versionEntityName;

    public function __construct(EntityManager $entityManager, $resourceHistoryEntityName, $versionEntityName)
    {
        $this->entityManger = $entityManager;
        $this->resourceHistoryEntityName = $resourceHistoryEntityName;
        $this->versionEntityName = $versionEntityName;
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
        $resourceRepo = $this->entityManger->getRepository($this->versionEntityName);

        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('createdDateObject', $greaterThanDate));
        $criteria->andWhere($criteria->expr()->lt('createdDateObject', $lessThanDate));

        $results = $resourceRepo->matching($criteria);

        return $results;
    }

    protected function versionRowToChangeLogEvent(PageVersionEntity $version)
    {
        $properties = $version->getProperties();

        $event = new ChangeLogEvent();
        $event->setDateTime($version->getCreatedDateObject());
        $event->setUserId($version->getCreatedByUserId());
        $event->setActionId('create');
        $event->setActionName('created');
        $event->setResourceId($version->getId());
        $event->setResourceTypeName('page draft version');
        $event->setResourceName('for ' . $properties['path']);
        $event->setMetaData([
            'siteCmsResourceId' => $version->getSiteCmsResourceId(),
        ]);

        return $event;
    }

    protected function getResourceHistoryRows(\DateTime $greaterThanDate, \DateTime $lessThanDate)
    {
        $resourceRepo = $this->entityManger->getRepository($this->resourceHistoryEntityName);

        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('createdDateObject', $greaterThanDate));
        $criteria->andWhere($criteria->expr()->lt('createdDateObject', $lessThanDate));

        $results = $resourceRepo->matching($criteria);

        return $results;
    }

    protected function resourceHistoryRowToChangeLogEvent(PageCmsResourceHistoryEntity $historyItem)
    {
        $cmsResource = $historyItem->getCmsResource();

        $contentVersionId = $historyItem->getContentVersionId();

        switch ($historyItem->getAction()) {
            case ActionCmsResource::PUBLISH_RESOURCE_NEW_VERSION;
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::PUBLISH_RESOURCE_SAME_VERSION;
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_NEW_VERSION;

                $actionDescription = 'modified an unpublished version of';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_SAME_VERSION;
                $actionDescription = 'depublished draft version #' . $contentVersionId . ' from';
                break;
            default:
                throw new \Exception('Unknown action type found: ' . $historyItem->getAction());
        }

        $event = new ChangeLogEvent();
        $event->setDateTime($historyItem->getCreatedDateObject());
        $event->setUserId($historyItem->getCreatedByUserId());
        $event->setActionId($historyItem->getAction());
        $event->setActionName($actionDescription);
        $event->setResourceId($cmsResource->getId());
        $event->setResourceTypeName('page');
        $event->setResourceName($cmsResource->getPath());
        $event->setMetaData([
            'siteCmsResourceId' => $cmsResource->getSiteCmsResourceId(),
            'contentVersionId' => $historyItem->getContentVersionId()
        ]);

        return $event;
    }
}
