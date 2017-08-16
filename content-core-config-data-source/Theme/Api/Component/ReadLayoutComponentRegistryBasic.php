<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentRegistry;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @todo   Implement this
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadLayoutComponentRegistry
{
    const CACHE_KEY = 'ZrcmsLayoutComponentRegistryBasic';

    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param Cache               $cache
     * @param string              $cacheKey
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY,
        $defaultComponentConfReaderServiceAlias = ReadLayoutComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasLayout::NAMESPACE_COMPONENT_CONFIG_READER,
            $cache,
            $cacheKey,
            $defaultComponentConfReaderServiceAlias
        );
    }
}
