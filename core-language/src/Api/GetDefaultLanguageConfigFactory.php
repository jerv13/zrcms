<?php

namespace Zrcms\CoreLanguage\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDefaultLanguageConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetDefaultLanguageConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $defaultLanguageConfig = $serviceContainer->get('config')['zrcms-language-default'];

        return new GetDefaultLanguageConfig(
            $defaultLanguageConfig
        );
    }
}
