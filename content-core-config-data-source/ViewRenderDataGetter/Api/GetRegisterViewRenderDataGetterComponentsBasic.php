<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfig;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ViewRenderDataGetterComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetRegisterComponentsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterViewRenderDataGetterComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterViewRenderDataGetterComponents
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
        string $componentClass = ViewRenderDataGetterComponentBasic::class,
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
