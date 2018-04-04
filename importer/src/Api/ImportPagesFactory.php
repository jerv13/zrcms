<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportPagesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportPages
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportPages(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(ImportPage::class)
        );
    }
}
