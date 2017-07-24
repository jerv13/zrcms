<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\View\Model\ViewComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponentsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigViewComponentsBasic extends GetConfigComponentsAbstract implements GetConfigViewComponents
{
    const CACHE_KEY = 'ZrcmsViewComponentConfigBasic';

    /**
     * @param array                   $registryConfig
     * @param ReadViewComponentConfig $readComponentConfig
     * @param Cache                   $cache
     * @param string                  $componentClass
     * @param string                  $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadViewComponentConfig $readComponentConfig,
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
