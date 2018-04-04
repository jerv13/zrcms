<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportOptionsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportOptions
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportOptions();
    }
}
