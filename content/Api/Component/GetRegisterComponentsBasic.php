<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Basic\Api\Component\GetRegisterBasicComponents;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterBasicComponents
{
    const CACHE_KEY = 'ZrcmsComponentConfigBasic';

    /**
     * @param ReadComponentRegistry $readComponentRegistry
     * @param BuildComponentObject  $buildComponentObject
     * @param Cache                 $cache
     * @param string                $cacheKey
     */
    public function __construct(
        ReadComponentRegistry $readComponentRegistry,
        BuildComponentObject $buildComponentObject,
        Cache $cache,
        string $cacheKey
    ) {
        parent::__construct(
            $readComponentRegistry,
            $buildComponentObject,
            $cache,
            $cacheKey
        );
    }
}
