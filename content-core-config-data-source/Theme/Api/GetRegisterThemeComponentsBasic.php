<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Model\LayoutComponentBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesThemeComponent;
use Zrcms\ContentCore\Theme\Model\ThemeComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterThemeComponentsBasic
    extends GetRegisterComponentsAbstract
    implements GetRegisterThemeComponents
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

    public function __invoke(
        array $options = []
    ): array
    {
        return parent::__invoke($options);
    }

    /**
     * @param array $themeComponentConfig
     *
     * @return array
     */
    protected function buildSubComponents(array $themeComponentConfig): array
    {
        $layoutVariationConfigs = Param::getArray(
            $themeComponentConfig,
            PropertiesThemeComponent::LAYOUT_VARIATIONS,
            []
        );

        $themeLocation ='';

        $layoutVariationsRegistry = [];

        foreach ($layoutVariationConfigs as $layoutVariationConfig) {
            $layoutName = Param::getRequired(
                $layoutVariationConfig,
                ComponentRegistryFields::NAME
            );
            $location = Param::getRequired(
                $layoutVariationConfig,
                ComponentRegistryFields::CONFIG_LOCATION
            );

            // Add theme location to layout location

            $layoutLocation = '';
            $layoutVariationsRegistry[$layoutName] = $location;
        }

        $layoutComponentConfigs = $this->readConfigs($layoutVariationsRegistry);

        $layoutVariations = [];

        foreach ($layoutComponentConfigs as $layoutComponentConfig) {

            $configs[] = new LayoutComponentBasic(
                $layoutComponentConfig,
                Param::get(
                    $layoutComponentConfig,
                    ComponentConfigFields::CREATED_BY_USER_ID,
                    Trackable::UNKNOWN_USER_ID
                ),
                Param::get(
                    $layoutComponentConfig,
                    ComponentConfigFields::CREATED_REASON,
                    Trackable::UNKNOWN_REASON
                )
            );
        }

        $themeComponentConfig[PropertiesThemeComponent::LAYOUT_VARIATIONS] = $layoutVariations;

        return $themeComponentConfig;
    }
}
