<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return Import
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new Import(
            $serviceContainer->get(FindSiteCmsResource::class),
            $serviceContainer->get(UpsertSiteCmsResource::class),
            $serviceContainer->get(UpsertPageCmsResource::class),
            $serviceContainer->get(UpsertPageTemplateCmsResource::class),
            $serviceContainer->get(UpsertContainerCmsResource::class),
            $serviceContainer->get(UpsertRedirectCmsResource::class)
        );
    }
}
