<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ChangeLogEvent;
use Zrcms\Content\Model\ActionCmsResource;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource\Base\Api\ChangeLog\BaseGetChangeLogByDateRange;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\ThemeCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\ThemeVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\ChangeLog\AbstractGetChangeLogByDateRange;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;

class GetChangeLogByDateRange extends AbstractGetChangeLogByDateRange
{
    protected $entityManger;

    protected function getResourceHistoryEntityName(): string
    {
        return LayoutCmsResourceHistoryEntity::class;
    }

    protected function getVersionEntityName(): string
    {
        return LayoutVersionEntity::class;
    }

    /**
     * @param LayoutVersionEntity $version
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
        $event->setResourceTypeName('layout draft version');
        $event->setResourceName('for ' . $properties[FieldsLayoutVersion::NAME]);

        return $event;
    }

    /**
     * @param LayoutCmsResourceHistoryEntity $historyItem
     * @return ChangeLogEvent
     * @throws \Exception
     */
    protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent
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
        $event->setResourceTypeName('layout');
        $event->setResourceName($cmsResource->getName());
        $event->setMetaData([
            'contentVersionId' => $historyItem->getContentVersionId()
        ]);

        return $event;
    }
}
