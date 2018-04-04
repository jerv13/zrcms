<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSiteContainersFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportSiteContainers
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportSiteContainers(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportSiteContainer::class)
        );
    }
}
