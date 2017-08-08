<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Repository;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Repository\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentRegistryBasic extends ReadComponentRegistryAbstract implements ReadBlockComponentRegistry
{
    const CACHE_KEY = 'ZrcmsBlockComponentRegistryBasic';

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
        string $defaultComponentConfReaderServiceAlias = ReadBlockComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER,
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
