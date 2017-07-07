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
     * @param $json The full json data string from a previous Zrcms export
     */
    function __invoke($json)
    {
        $data = json_decode($json);

        $createdByUser = 'import-script';//@TODO get current logged in user
        $createdByReason = 'Import script ' . get_class($this);

        foreach ($data['sites'] as $site) {
            $this->createSitePublished->__invoke(
                $site['host'],
                $site['theme'],
                $site['properties'],
                $createdByUser,
                $createdByReason,
                $site['id']
            );
        }

        foreach ($data['pages'] as $page) {
            $this->createPagePublished->__invoke(
                $page['uri'],
                $createdByUser,
                $createdByReason,
                $page['properties'],
                $page['blockInstances']
            );
        }

        foreach ($data['containers'] as $container) {
            $this->createContainerPublished->__invoke(
                $container['uri'],
                $createdByUser,
                $createdByReason,
                $container['properties'],
                $container['blockInstances']
            );
        }
    }
}
