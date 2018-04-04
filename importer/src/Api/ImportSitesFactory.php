<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportSitesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportSites
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportSites(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportSite::class)
        );
    }
}
