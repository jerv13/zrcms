<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPageTemplatesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportPageTemplates
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportPageTemplates(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportPageTemplate::class)
        );
    }
}
