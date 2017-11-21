<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\ChangeLog;

use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Proxy\__CG__\Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ChangeLog\Api\ChangeLogEvent;
use Zrcms\Content\Model\ActionCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Base\Api\ChangeLog\BaseGetChangeLogByDateRange;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Shared\Api\ChangeLog\AbstractGetChangeLogByDateRange;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

class GetChangeLogByDateRange extends AbstractGetChangeLogByDateRange
{
    protected $entityManger;

    protected function getResourceHistoryEntityName(): string
    {
        return RedirectCmsResourceHistoryEntity::class;
    }

    protected function getVersionEntityName(): string
    {
        return RedirectVersionEntity::class;
    }

    /**
     * @param RedirectVersionEntity $version
     * @return ChangeLogEvent
     */
    protected function versionRowToChangeLogEvent($version): ChangeLogEvent
    {
        $properties = $version->getProperties();

        $event = new ChangeLogEvent();
        $event->setDateTime($version->getCreatedDateObject());
        $event->setUserId($version->getCreatedByUserId());
        $event->setActionId('create');
        $event->setActionName('created');
        $event->setResourceId($version->getId());
        $event->setResourceTypeName('redirect draft version');
        $event->setResourceName('for ' . $version->getRequestPath());
        $metaData = [];
        if (!empty($version->getSiteCmsResourceId())) {
            $metaData['siteCmsResourceId'] = $version->getSiteCmsResourceId();
        }
        $event->setMetaData($metaData);

        return $event;
    }

    /**
     * @param RedirectCmsResourceHistoryEntity $historyItem
     * @return ChangeLogEvent
     * @throws \Exception
     */
    protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent
    {
        /**
         * @var $cmsResource RedirectCmsResourceEntity
         */
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
        $event->setResourceTypeName('redirect');
        $event->setResourceName($cmsResource->getRequestPath());
        $metaData = ['contentVersionId' => $historyItem->getContentVersionId()];
        if (!empty($historyItem->getContentVersion()->getSiteCmsResourceId())) {
            $metaData['siteCmsResourceId'] = $historyItem->getContentVersion()->getSiteCmsResourceId();
        }
        $event->setMetaData($metaData);

        return $event;
    }
}
