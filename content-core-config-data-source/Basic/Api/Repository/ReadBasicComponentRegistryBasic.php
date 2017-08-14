<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api\Repository;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Basic\Api\Repository\ReadBasicComponentConfigJsonFile;
use Zrcms\ContentCore\Basic\Api\Repository\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Basic\Model\ServiceAliasBasic;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadBasicComponentRegistry
{
    const CACHE_KEY = 'ZrcmsBasicComponentRegistryBasic';

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
        string $defaultComponentConfReaderServiceAlias = ReadBasicComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasBasic::NAMESPACE_COMPONENT_CONFIG_READER,
            $cache,
            $cacheKey,
            $defaultComponentConfReaderServiceAlias
        );
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array
    {
        return parent::__invoke($options);
    }
}
