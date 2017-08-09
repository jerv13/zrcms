<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponentBasic;
use Zrcms\ContentCoreConfigDataSource\View\Api\Repository\ReadViewLayoutTagsComponentRegistryBasic;

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
     * @param Cache                                          $cache
     * @param string                                         $componentClass
     * @param string                                         $cacheKey
     */
    public function __construct(
        ReadViewLayoutTagsComponentRegistryBasic $readComponentRegistry,
        Cache $cache,
        string $componentClass = ViewLayoutTagsComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $readComponentRegistry,
            $cache,
            $componentClass,
            $cacheKey
        );
    }

    public function __invoke(
        array $options = []
    ): array
    {
        $registry =  parent::__invoke($options);

        return $registry;
    }
}
