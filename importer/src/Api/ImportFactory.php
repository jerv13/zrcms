<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentRedirect\Api\Action\PublishRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Repository\InsertRedirectVersion;

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
            $serviceContainer->get(InsertSiteVersion::class),
            $serviceContainer->get(PublishSiteCmsResource::class),
            $serviceContainer->get(InsertPageContainerVersion::class),
            $serviceContainer->get(PublishPageContainerCmsResource::class),
            $serviceContainer->get(InsertContainerVersion::class),
            $serviceContainer->get(PublishContainerCmsResource::class),
            $serviceContainer->get(InsertRedirectVersion::class),
            $serviceContainer->get(PublishRedirectCmsResource::class)
        );
    }
}
