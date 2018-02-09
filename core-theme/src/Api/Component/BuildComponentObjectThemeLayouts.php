<?php

namespace Zrcms\CoreTheme\Api\Component;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\SearchComponentConfigs;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Component;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponentConfig;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Zrcms\CoreTheme\Fields\FieldsThemeComponentConfig;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectThemeLayouts extends BuildComponentObjectByType implements BuildComponentObject
{
    protected $readComponentConfigs;
    protected $searchComponentConfigs;
    protected $buildComponentObjectThemeLayout;

    /**
     * @param ReadComponentConfigs            $readComponentConfigs
     * @param SearchComponentConfigs          $searchComponentConfigs
     * @param BuildComponentObjectThemeLayout $buildComponentObjectThemeLayout
     * @param GetTypeValue                    $getTypeValue
     * @param string                          $defaultComponentClass
     */
    public function __construct(
        ReadComponentConfigs $readComponentConfigs,
        SearchComponentConfigs $searchComponentConfigs,
        BuildComponentObjectThemeLayout $buildComponentObjectThemeLayout,
        GetTypeValue $getTypeValue,
        string $defaultComponentClass = ThemeComponentBasic::class
    ) {
        $this->readComponentConfigs = $readComponentConfigs;
        $this->searchComponentConfigs = $searchComponentConfigs;
        $this->buildComponentObjectThemeLayout = $buildComponentObjectThemeLayout;

        parent::__construct(
            $getTypeValue,
            $defaultComponentClass
        );
    }

    /**
     * @param array $componentConfig
     * @param array $options
     *
     * @return Component
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __invoke(
        array $componentConfig,
        array $options = []
    ): Component {
        $componentConfig = $this->prepareConfig($componentConfig, $options);

        return parent::__invoke($componentConfig, $options);
    }

    /**
     * @param array $themeComponentConfig
     * @param array $options
     *
     * @return array
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function prepareConfig(
        array $themeComponentConfig,
        array $options = []
    ):array {
        $componentConfigs = $this->readComponentConfigs->__invoke();

        $themeName = Property::getRequired(
            $themeComponentConfig,
            FieldsThemeComponentConfig::NAME
        );

        $layoutComponentConfigs = $this->searchComponentConfigs->__invoke(
            $componentConfigs,
            [
                FieldsComponentConfig::TYPE => 'theme-layout',
                FieldsLayoutComponentConfig::THEME_NAME => $themeName
            ]
        );

        $layoutVariations = [];

        foreach ($layoutComponentConfigs as $layoutComponentConfig) {
            $layoutVariations[] = $this->buildComponentObjectThemeLayout->__invoke($layoutComponentConfig, $options);
        }

        $themeComponentConfig[FieldsThemeComponent::LAYOUT_VARIATIONS] = $layoutVariations;

        return $themeComponentConfig;
    }
}
