<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetTypeValue;
use Zrcms\Content\Model\ServiceAliasComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryTypeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentRegistryByType
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components'];

        return new ReadComponentRegistryByType(
            $serviceContainer,
            $registry,
            $serviceContainer->get(GetTypeValue::class),
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(Cache::class),
            ReadComponentRegistryByType::CACHE_KEY,
            ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER,
            ReadComponentConfigJsonFile::class,
            PrepareComponentConfigNoop::class
        );
    }
}
