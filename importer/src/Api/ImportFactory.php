<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;
use Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;

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
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportSites::class),
            $serviceContainer->get(ImportRedirects::class)
        );
    }
}
