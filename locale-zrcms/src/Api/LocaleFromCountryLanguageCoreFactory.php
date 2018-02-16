<?php

namespace Zrcms\LocaleZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LocaleFromCountryLanguageCoreFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return LocaleFromCountryLanguageCore
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new LocaleFromCountryLanguageCore(
            $serviceContainer->get(FindComponent::class)
        );
    }
}
