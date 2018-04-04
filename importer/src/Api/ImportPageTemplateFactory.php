<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\InsertPageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPageTemplateFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportPageTemplate
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportPageTemplate(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(InsertPageVersion::class),
            $serviceContainer->get(CreatePageTemplateCmsResource::class)
        );
    }
}
