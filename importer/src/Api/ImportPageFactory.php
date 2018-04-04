<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportPage(
            $serviceContainer->get(ImportOptions::class),
            $serviceContainer->get(InsertPageVersion::class),
            $serviceContainer->get(CreatePageCmsResource::class)
        );
    }
}
