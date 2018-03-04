<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return Import
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new Import(
            $serviceContainer->get(FindSiteCmsResource::class),
            $serviceContainer->get(InsertSiteVersion::class),
            $serviceContainer->get(UpsertSiteCmsResource::class),
            $serviceContainer->get(InsertPageVersion::class),
            $serviceContainer->get(UpsertPageCmsResource::class),
            $serviceContainer->get(UpsertPageTemplateCmsResource::class),
            $serviceContainer->get(InsertContainerVersion::class),
            $serviceContainer->get(UpsertContainerCmsResource::class),
            $serviceContainer->get(FindRedirectCmsResource::class),
            $serviceContainer->get(InsertRedirectVersion::class),
            $serviceContainer->get(UpsertRedirectCmsResource::class)
        );
    }
}
