<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\View\Model\ViewComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponentsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigViewRenderDataGetterComponentsBasic
    extends GetConfigComponentsAbstract
    implements GetConfigViewRenderDataGetterComponents
{
    const CACHE_KEY = 'ZrcmsViewRenderDataGetterComponentConfigBasic';

    /**
     * @param array                                   $registryConfig
     * @param ReadViewRenderDataGetterComponentConfig $readComponentConfig
     * @param Cache                                   $cache
     * @param string                                  $componentClass
     * @param string                                  $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadViewRenderDataGetterComponentConfig $readComponentConfig,
        Cache $cache,
        string $componentClass = ViewComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $registryConfig,
            $readComponentConfig,
            $cache,
            $componentClass,
            $cacheKey
        );
    }
}
