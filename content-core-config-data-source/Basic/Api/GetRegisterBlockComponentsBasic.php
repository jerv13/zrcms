<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\Content\Model\Properties;
use Zrcms\ContentCore\Basic\Api\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Api\Repository\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Basic\Model\BasicComponentBasic;
use Zrcms\ContentCore\Basic\Model\PropertiesComponentBasic;
use Zrcms\Param\Param;

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
     * @param string                     $defaultComponentClass
     * @param string                     $cacheKey
     */
    public function __construct(
        ReadBasicComponentRegistry $readComponentRegistry,
        Cache $cache,
        string $defaultComponentClass = BasicComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        parent::__construct(
            $readComponentRegistry,
            $cache,
            $defaultComponentClass,
            $cacheKey
        );
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array
    {
        $components =  parent::__invoke($options);

        return $components;
    }

    /**
     * @param array  $componentRegistry
     * @param string $defaultComponentClass
     *
     * @return array
     */
    protected function buildComponentObjects(
        array $componentRegistry,
        string $defaultComponentClass
    ) {
        $configs = [];
        foreach ($componentRegistry as $componentConfig) {
            // Basic components might have special classes
            $componentClass = Param::get(
                $componentConfig,
                PropertiesComponentBasic::COMPONENT_CLASS,
                $defaultComponentClass
            );
            $configs[] = $this->buildComponentObject(
                $componentConfig,
                $componentClass
            );
        }

        return $configs;
    }
}
