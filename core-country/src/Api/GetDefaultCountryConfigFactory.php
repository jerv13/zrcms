<?php

namespace Zrcms\CoreCountry\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDefaultCountryConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetDefaultCountryConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $defaultCountryConfig = $serviceContainer->get('config')['zrcms-country-default'];

        return new GetDefaultCountryConfig(
            $defaultCountryConfig
        );
    }
}
