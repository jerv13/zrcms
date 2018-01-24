<?php

namespace Zrcms\CoreThemeDoctrine\Api\ChangeLog;

use Zrcms\Core\Model\ActionCmsResource;
use Zrcms\Core\Model\ChangeLogEvent;
use Zrcms\Core\Model\ChangeLogEventBasic;
use Zrcms\CoreApplicationDoctrine\Api\ChangeLog\GetChangeLogByDateRangeAbstract as CoreGetChangLogAbstract;
use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;

class GetLayoutChangeLogByDateRangeAbstract extends CoreGetChangLogAbstract
{
    protected $entityManger;

    /**
     * @return string
     */
    protected function getResourceHistoryEntityName(): string
    {
        return LayoutCmsResourceHistoryEntity::class;
    }

    /**
     * @return string
     */
    protected function getVersionEntityName(): string
    {
        return LayoutVersionEntity::class;
    }

    /**
     * @param LayoutVersionEntity $version
     *
     * @return ChangeLogEvent
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    protected function versionRowToChangeLogEvent($version): ChangeLogEvent
    {
        $properties = $version->getProperties();

        $event = new ChangeLogEventBasic();
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
     *
     * @return ChangeLogEvent
     * @throws \Exception
     */
    protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent
    {
        $cmsResource = $historyItem->getCmsResource();

        $contentVersionId = $historyItem->getContentVersionId();

        switch ($historyItem->getAction()) {
            case ActionCmsResource::PUBLISH_RESOURCE_NEW_VERSION:
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::PUBLISH_RESOURCE_SAME_VERSION:
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_NEW_VERSION:
                $actionDescription = 'modified an unpublished version of';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_SAME_VERSION:
                $actionDescription = 'depublished draft version #' . $contentVersionId . ' from';
                break;
            default:
                throw new \Exception('Unknown action type found: ' . $historyItem->getAction());
        }

        $event = new ChangeLogEventBasic();
        $event->setDateTime($historyItem->getCreatedDateObject());
        $event->setUserId($historyItem->getCreatedByUserId());
        $event->setActionId($historyItem->getAction());
        $event->setActionName($actionDescription);
        $event->setResourceId($cmsResource->getId());
        $event->setResourceTypeName('layout');
        $event->setResourceName($cmsResource->getName());
        $event->setMetaData(
            [
                'contentVersionId' => $historyItem->getContentVersionId()
            ]
        );

        return $event;
    }
}
