<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportRedirectsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportRedirects
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportRedirects(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportRedirect::class)
        );
    }
}
