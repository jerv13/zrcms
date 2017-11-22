<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\GetRegisterComponentsAbstract;
use Zrcms\ContentCore\Block\Api\Component\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Model\BlockComponent;
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
     * @param string                     $cacheKey
     */
    public function __construct(
        PrepareBlockConfigBc $prepareBlockConfig,
        ReadBlockComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->prepareBlockConfig = $prepareBlockConfig;

        parent::__construct(
            $readComponentRegistry,
            $cache,
            $cacheKey,
            BlockComponentBasic::class,
            BlockComponent::class
        );
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
