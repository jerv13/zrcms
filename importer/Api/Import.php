<?php

namespace Zrcms\Importer\Api;

use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentCore\Container\Api\CreateContainerPublished;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerVersion;
use Zrcms\ContentCore\Page\Api\CreatePagePublished;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteVersionByHost;
use Zrcms\ContentCore\Site\Api\CreateSitePublished;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\Uri\Api\BuildCmsUri;
use Zrcms\ContentCore\Uri\Api\ParseCmsUri;
use Zrcms\ContentCore\Uri\Model\Uri;

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
