<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return Import
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new Import(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportSites::class),
            $serviceContainer->get(ImportRedirects::class)
        );
    }
}
