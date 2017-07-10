<?php

namespace Zrcms\Importer\Api;

use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Page\Api\CreatePagePublished;
use Zrcms\Core\Site\Api\CreateSitePublished;

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

        $convertUri = function ($oldUri) use ($siteIdOldToNewMap) {
            $parsedUri = $this->parseCmsUri($oldUri);
            
            return $this->buildCmsUri->_invoke();
        };

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
                $page['uri'],
                $currentUserId,
                $createdByReason,
                $page['properties']
            );
        }

        foreach ($data['containers'] as $container) {
            $this->createContainerPublished->__invoke(
                $container['uri'],
                $currentUserId,
                $createdByReason,
                $container['properties']
            );
        }
    }
}
