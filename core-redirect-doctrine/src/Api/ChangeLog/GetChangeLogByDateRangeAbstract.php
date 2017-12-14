<?php

namespace Zrcms\CoreRedirectDoctrine\Api\ChangeLog;

use Zrcms\Core\Model\ActionCmsResource;
use Zrcms\Core\Model\ChangeLogEvent;
use Zrcms\Core\Model\ChangeLogEventBasic;
use Zrcms\CoreApplicationDoctrine\Api\ChangeLog\GetChangeLogByDateRangeAbstract as CoreGetChangLogAbstract;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;

class GetChangeLogByDateRangeAbstract extends CoreGetChangLogAbstract
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
     *
     * @return ChangeLogEvent
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
     *
     * @return ChangeLogEvent
     * @throws \Exception
     */
    protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent
    {
        /**
         * @var RedirectCmsResourceEntity $cmsResource
         */
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
