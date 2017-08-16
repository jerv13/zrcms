<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\ReadComponentRegistryAbstract;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigJsonFile;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentRegistry;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentRegistryBasic
    extends ReadComponentRegistryAbstract
    implements ReadViewLayoutTagsComponentRegistry
{
    const CACHE_KEY = 'ZrcmsViewLayoutTagsComponentRegistryBasic';

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
        $defaultComponentConfReaderServiceAlias = ReadViewLayoutTagsComponentConfigJsonFile::class
    ) {
        parent::__construct(
            $registry,
            $getServiceFromAlias,
            ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_CONFIG_READER,
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
        $registry = parent::__invoke($options);

        return $registry;
    }
}
