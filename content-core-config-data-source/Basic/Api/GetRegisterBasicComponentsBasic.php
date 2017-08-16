<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Basic\Api\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Model\BasicComponent;
use Zrcms\ContentCore\Basic\Model\BasicComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterBasicComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterBasicComponents
{
    const CACHE_KEY = 'ZrcmsBasicComponentConfigBasic';

    /**
     * @param ReadBasicComponentRegistry $readComponentRegistry
     * @param Cache                      $cache
     * @param string                     $cacheKey
     */
    public function __construct(
        ReadBasicComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $readComponentRegistry,
            $cache,
            $cacheKey,
            BasicComponentBasic::class,
            BasicComponent::class
        );
    }
}
