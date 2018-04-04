<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportUtilitiesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportUtilities
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportUtilities();
    }
}
