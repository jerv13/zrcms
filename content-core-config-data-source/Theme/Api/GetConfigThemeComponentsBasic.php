<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Theme\Model\ThemeComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponentsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigThemeComponentsBasic
    extends GetConfigComponentsAbstract
    implements GetConfigThemeComponents
{
    const CACHE_KEY = 'ZrcmsThemeComponentConfigBasic';

    /**
     * @param array                    $registryConfig
     * @param ReadThemeComponentConfig $readComponentConfig
     * @param Cache                    $cache
     * @param string                   $componentClass
     * @param string                   $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadThemeComponentConfig $readComponentConfig,
        Cache $cache,
        string $componentClass = ThemeComponentBasic::class,
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
