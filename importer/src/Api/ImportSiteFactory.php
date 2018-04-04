<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSiteFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportSite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportSite(
            $serviceContainer->get(ImportOptions::class),
            $serviceContainer->get(FindSiteCmsResource::class),
            $serviceContainer->get(InsertSiteVersion::class),
            $serviceContainer->get(CreateSiteCmsResource::class),
            $serviceContainer->get(ImportPages::class),
            $serviceContainer->get(ImportPageTemplates::class),
            $serviceContainer->get(ImportSiteContainers::class),
            $serviceContainer->get(ImportRedirects::class)
        );
    }
}
