<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\ViewLayoutTags\Api\GetRegisterViewLayoutTagsGetterComponents;
use Zrcms\ContentCore\ViewLayoutTags\Model\ViewLayoutTagsGetterComponentBasic;
use Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentRegistryBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterViewLayoutTagsGetterComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterViewLayoutTagsGetterComponents
{
    const CACHE_KEY = 'ZrcmsViewLayoutTagsGetterComponentConfigBasic';

    /**
     * @param ReadViewLayoutTagsGetterComponentRegistryBasic $readComponentRegistry
     * @param Cache                                          $cache
     * @param string                                         $componentClass
     * @param string                                         $cacheKey
     */
    public function __construct(
        ReadViewLayoutTagsGetterComponentRegistryBasic $readComponentRegistry,
        Cache $cache,
        string $componentClass = ViewLayoutTagsGetterComponentBasic::class,
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
