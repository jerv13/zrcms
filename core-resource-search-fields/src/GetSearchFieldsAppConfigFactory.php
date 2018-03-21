<?php

namespace Zrcms\CoreResourceSearchFields;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSearchFieldsAppConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetSearchFieldsAppConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');
        return new GetSearchFieldsAppConfig(
            $appConfig['zrcms-resource-search-fields']
        );
    }
}
