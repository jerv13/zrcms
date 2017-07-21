<?php

namespace Zrcms\Importer\Api;

use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Page\Api\Action\PublishPageContainerVersion;
use Zrcms\Core\Page\Api\CreatePagePublished;
use Zrcms\Core\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\Core\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\Core\Page\Model\PageContainerVersionBasic;
use Zrcms\Core\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\Core\Page\Model\PropertiesPageContainerVersion;
use Zrcms\Core\Site\Api\Action\PublishSiteVersion;
use Zrcms\Core\Site\Api\Action\PublishSiteVersionByHost;
use Zrcms\Core\Site\Api\CreateSitePublished;
use Zrcms\Core\Site\Api\Repository\InsertSiteVersion;
use Zrcms\Core\Site\Model\SiteCmsResourceBasic;
use Zrcms\Core\Site\Model\SiteVersionBasic;
use Zrcms\Core\Uri\Api\BuildCmsUri;
use Zrcms\Core\Uri\Api\ParseCmsUri;
use Zrcms\Core\Uri\Model\Uri;

class Import
{
    /**
     * @var InsertSiteVersion
     */
    protected $insertSiteVersion;
    /**
     * @var PublishSiteVersion
     */
    protected $publishSite;

    /**
     * @var InsertPageContainerVersion
     */
    protected $insertPageVersion;

    /**
     * @var PublishPageContainerVersion
     */
    protected $publishPage;
    protected $insertContainerVersion;
    protected $publishContainer;

    public function __construct(
        CreateSitePublished $createSitePublished,
        CreatePagePublished $createPagePublished,
        CreateContainerPublished $createContainerPublished
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

        foreach ($data['sites'] as $site) {
            $version = $this->insertSiteVersion->__invoke(new SiteVersionBasic(
                $site['properties'],
                $createdByUserId,
                $createdReason
            ));

            $published = $this->publishSite->__invoke(
                new SiteCmsResourceBasic([
                        'id' => $site['id'],
                        'host' => $site['host'],
                        PropertiesCmsResource::CONTENT_VERSION_ID => $version->getId()
                    ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
        }

        foreach ($data['pages'] as $page) {

            $version = $this->insertPageVersion->__invoke(new PageContainerVersionBasic(
                $page['properties'],
                $createdByUserId,
                $createdReason
            ));

            $published = $this->publishPage->__invoke(
                new PageContainerCmsResourceBasic([
                    PropertiesPageContainerCmsResource::SITE_ID => $site['id'],
                    PropertiesPageContainerCmsResource::PATH => $site['path'],
                    PropertiesPageContainerCmsResource::CONTENT_VERSION_ID => $version->getId()
                ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
        }

        foreach ($data['containers'] as $container) {

            $version = $this->insertContainerVersion->__invoke(new ConatinerVersionBasic(
                $container['properties'],
                $createdByUserId,
                $createdReason
            ));

            $published = $this->publishContainer->__invoke(
                new ConatinerCmsResourceBasic([
                    PropertiesConatinerCmsResource::SITE_ID => $site['id'],
                    PropertiesConatinerCmsResource::PATH => $site['path'],
                    PropertiesConatinerCmsResource::CONTENT_VERSION_ID => $version->getId()
                ],
                    $createdByUserId,
                    $createdReason
                ),
                $createdByUserId,
                $createdReason
            );
        }
    }
}
