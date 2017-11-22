<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponentBasic;
use Zrcms\ContentCoreConfigDataSource\View\Api\Component\ReadViewLayoutTagsComponentRegistryBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterViewLayoutTagsComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterViewLayoutTagsComponents
{
    const CACHE_KEY = 'ZrcmsViewLayoutTagsComponentConfigBasic';

    /**
     * @param ReadViewLayoutTagsComponentRegistryBasic $readComponentRegistry
     * @param Cache                                    $cache
     * @param string                                   $cacheKey
     */
    public function __construct(
        ReadViewLayoutTagsComponentRegistryBasic $readComponentRegistry,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $readComponentRegistry,
            $cache,
            $cacheKey,
            ViewLayoutTagsComponentBasic::class,
            ViewLayoutTagsComponent::class
        );
    }
}
