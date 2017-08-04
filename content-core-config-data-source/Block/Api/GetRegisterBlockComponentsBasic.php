<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Api\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetRegisterComponentsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterBlockComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterBlockComponents
{
    const CACHE_KEY = 'ZrcmsBlockComponentConfigBasic';

    /**
     * @param array                    $registryConfig
     * @param ReadBlockComponentConfig $readComponentConfig
     * @param Cache                    $cache
     * @param string                   $componentClass
     * @param string                   $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadBlockComponentConfig $readComponentConfig,
        Cache $cache,
        string $componentClass = BlockComponentBasic::class,
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
