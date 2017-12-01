<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadComponentRegistry
{
    const CACHE_KEY = 'ZrcmsComponentRegistryBasic';

    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $serviceAliasNamespace
     * @param Cache               $cache
     * @param string              $cacheKey
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        string $serviceAliasNamespace,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY,
        string $defaultComponentConfReaderServiceAlias = ReadComponentConfig::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            $serviceAliasNamespace,
            $cache,
            $cacheKey,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
