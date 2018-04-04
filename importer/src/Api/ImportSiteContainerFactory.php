<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSiteContainerFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportSiteContainer
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportSiteContainer(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(InsertSiteContainerVersion::class),
            $serviceContainer->get(CreateSiteContainerCmsResource::class)
        );
    }
}
