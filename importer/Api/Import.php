<?php

namespace Zrcms\Importer\Api;

use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Page\Api\CreatePagePublished;
use Zrcms\Core\Site\Api\CreateSitePublished;
use Zrcms\Core\Uri\Api\BuildCmsUri;
use Zrcms\Core\Uri\Api\ParseCmsUri;
use Zrcms\Core\Uri\Model\Uri;

class Import
{
    protected $createSitePublished;
    protected $createPagePublished;
    protected $createContainerPublished;
    protected $buildCmsUri;
    protected $parseCmsUri;

    public function __construct(
        CreateSitePublished $createSitePublished,
        CreatePagePublished $createPagePublished,
        CreateContainerPublished $createContainerPublished,
        BuildCmsUri $buildCmsUri,
        ParseCmsUri $parseCmsUri
    ) {
        $this->createPagePublished = $createPagePublished;
        $this->createContainerPublished = $createContainerPublished;
        $this->createSitePublished = $createSitePublished;
        $this->buildCmsUri = $buildCmsUri;
        $this->parseCmsUri = $parseCmsUri;
    }

    /**
     * This imports sites, pages, and containers from an exported JSON array into the database.
     *
     * @param $json string The full json data string from a previous Zrcms export
     */
    function __invoke($json, $currentUserId)
    {
        $data = json_decode($json);

        $createdByReason = 'Import script ' . get_class($this);

        $siteIdOldToNewMap = [];

        foreach ($data['sites'] as $site) {
            $newSite = $this->createSitePublished->__invoke(
                $site['host'],
                $site['theme'],
                $site['properties'],
                $currentUserId,
                $createdByReason
            );
            $siteIdOldToNewMap[$site['id']] = $newSite->getId();
        }

        foreach ($data['pages'] as $page) {
            $this->createPagePublished->__invoke(
                $this->replaceSiteIdInUri($page['uri'], $siteIdOldToNewMap),
                $currentUserId,
                $createdByReason,
                $page['properties']
            );
        }

        foreach ($data['containers'] as $container) {
            $this->createContainerPublished->__invoke(
                $this->replaceSiteIdInUri($container['uri'], $siteIdOldToNewMap),
                $currentUserId,
                $createdByReason,
                $container['properties']
            );
        }
    }

    protected function replaceSiteIdInUri(string $oldUri, array $siteIdOldToNewMap)
    {
        /**
         * @var Uri $oldParsedUri
         */
        $oldParsedUri = $this->parseCmsUri->__invoke($oldUri);

        return $this->buildCmsUri->__invoke(
            $siteIdOldToNewMap[$oldParsedUri->getSiteId()],
            $oldParsedUri->getType(),
            $oldParsedUri->getPath()
        );
    }
}
