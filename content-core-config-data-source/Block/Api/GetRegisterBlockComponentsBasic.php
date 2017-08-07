<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterBlockComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterBlockComponents
{
    const CACHE_KEY = 'ZrcmsBlockComponentConfigBasic';

    /**
     * @var PrepareBlockConfigBc
     */
    protected $prepareBlockConfig;

    /**
     * @param PrepareBlockConfigBc       $prepareBlockConfig
     * @param ReadBlockComponentRegistry $readComponentRegistry
     * @param Cache                      $cache
     * @param string                     $componentClass
     * @param string                     $cacheKey
     */
    public function __construct(
        PrepareBlockConfigBc $prepareBlockConfig,
        ReadBlockComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $componentClass = BlockComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->prepareBlockConfig = $prepareBlockConfig;

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
        $components =  parent::__invoke($options);

        return $components;
    }

    /**
     * @param array $componentConfig
     *
     * @return array
     */
    public function prepareConfig(array $componentConfig): array
    {
        return $this->prepareBlockConfig->__invoke($componentConfig);
    }
}
