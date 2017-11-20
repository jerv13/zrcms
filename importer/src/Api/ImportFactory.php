<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\Container\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentRedirect\Api\CmsResource\UpsertRedirectCmsResource;

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
            $serviceContainer->get(UpsertSiteCmsResource::class),
            $serviceContainer->get(UpsertPageCmsResource::class),
            $serviceContainer->get(UpsertPageTemplateCmsResource::class),
            $serviceContainer->get(UpsertContainerCmsResource::class),
            $serviceContainer->get(UpsertRedirectCmsResource::class)
        );
    }
}
