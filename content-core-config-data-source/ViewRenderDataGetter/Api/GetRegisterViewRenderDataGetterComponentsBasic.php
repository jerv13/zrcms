<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\GetRegisterViewRenderDataGetterComponents;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ViewRenderDataGetterComponentBasic;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\Repository\ReadViewRenderDataGetterComponentRegistryBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterViewRenderDataGetterComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterViewRenderDataGetterComponents
{
    const CACHE_KEY = 'ZrcmsViewRenderDataGetterComponentConfigBasic';

    /**
     * @param ReadViewRenderDataGetterComponentRegistryBasic $readComponentRegistry
     * @param Cache                                          $cache
     * @param string                                         $componentClass
     * @param string                                         $cacheKey
     */
    public function __construct(
        ReadViewRenderDataGetterComponentRegistryBasic $readComponentRegistry,
        Cache $cache,
        string $componentClass = ViewRenderDataGetterComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $readComponentRegistry,
            $cache,
            $componentClass,
            $cacheKey
        );
    }
}
