<?php


namespace Zrcms\ChangeLog\Api;

use Zrcms\Content\Model\ChangeLogEvent;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResource;

class ChangeLogEventToString
{
    protected $findSiteCmsResource;

    protected $siteIdToHostCache = [];

    public function __construct(
        FindSiteCmsResource $findSiteCmsResource
    ) {
        $this->findSiteCmsResource = $findSiteCmsResource;
    }

    public function __invoke(ChangeLogEvent $changeLogEvent)
    {
        $userDescription = 'User #' . $changeLogEvent->getUserId()
            . ($changeLogEvent->getUserName() ? ' (' . $changeLogEvent->getUserName() . ')' : '');

        $metaData = $changeLogEvent->getMetaData();

        $resourceDescription = $changeLogEvent->getResourceTypeName()
            . ' #' . $changeLogEvent->getResourceId()
            . ($changeLogEvent->getResourceName() ? ' (' . $changeLogEvent->getResourceName() . ')' : '');

        $humanNotes = '';

        if (isset($metaData['siteCmsResourceId'])) {
            $humanNotes .= ' This was for site #' . $metaData['siteCmsResourceId'] .
                ' (currently ' . $this->siteIdToHost($metaData['siteCmsResourceId']) . ').';
        }

        return $userDescription
            . ' ' . $changeLogEvent->getActionName()
            . ' ' . $resourceDescription
            . '.'
            . $humanNotes;
    }

    protected function siteIdToHost($siteId)
    {
        if (array_key_exists($siteId, $this->siteIdToHostCache)) {
            return $this->siteIdToHostCache[$siteId];
        }

        $site = $this->findSiteCmsResource->__invoke($siteId);

        if ($site === null) {
            throw new \Exception('Site not found: ' . $site);
        }

        $host = $site->getHost();

        $this->siteIdToHostCache[$siteId] = $host;

        return $host;
    }
}
