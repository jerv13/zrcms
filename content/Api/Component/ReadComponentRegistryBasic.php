<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadComponentRegistry
{
    const CACHE_KEY = 'ZrcmsComponentRegistryBasic';

    /**
     * @param array                                             $registry
     * @param ReadComponentConfig|ReadComponentConfigByStrategy $readComponentConfig
     * @param Cache                                             $cache
     * @param string                                            $cacheKey
     */
    public function __construct(
        array $registry,
        ReadComponentConfig $readComponentConfig,
        Cache $cache,
        $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $registry,
            $readComponentConfig,
            $cache,
            $cacheKey
        );
    }
}
