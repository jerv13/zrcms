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

    public function __construct(
        CreateSitePublished $createSitePublished,
        CreatePagePublished $createPagePublished,
        CreateContainerPublished $createContainerPublished
    ) {
        $this->createPagePublished = $createPagePublished;
        $this->createContainerPublished = $createContainerPublished;
        $this->createSitePublished = $createSitePublished;
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

        foreach ($data['sites'] as $site) {
            $this->createSitePublished->__invoke(
                $site['host'],
                $site['theme'],
                $site['properties'],
                $currentUserId,
                $createdByReason
            );
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
