<?php

namespace Zrcms\CoreTheme\Api\Component;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\BuildComponentObjectDefault;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Fields\FieldsComponentRegistry;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponent;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponentConfig;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Zrcms\CoreTheme\Fields\FieldsThemeComponentConfig;
use Zrcms\CoreTheme\Model\LayoutComponentBasic;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectThemeLayouts extends BuildComponentObjectDefault implements BuildComponentObject
{
    protected $readComponentConfig;

    /**
     * @todo Get layout components normally from registry, this only supports ReadComponentConfigJsonFile
     *
     * @param ReadComponentConfigJsonFile $readComponentConfig
     * @param GetTypeValue        $getTypeValue
     * @param string              $defaultComponentClass
     */
    public function __construct(
        ReadComponentConfigJsonFile $readComponentConfig,
        GetTypeValue $getTypeValue,
        string $defaultComponentClass = ThemeComponentBasic::class
    ) {
        $this->readComponentConfig = $readComponentConfig;

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
     */
    public function __invoke(
        array $componentConfig,
        array $options = []
    ): Component
    {
        $componentConfig = $this->prepareConfig($componentConfig, $options);

        return parent::__invoke($componentConfig, $options);
    }

    /**
     * We prepare here because we are dealing with object which we do not want cached in the component config
     *
     * @param array $themeComponentConfig
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function prepareConfig(
        array $themeComponentConfig,
        array $options = []
    ):array {
        $layoutComponentRegistry = Param::getArray(
            $themeComponentConfig,
            FieldsThemeComponentConfig::LAYOUT_COMPONENTS,
            []
        );

        $themeModuleDirectory = Param::getRequired(
            $themeComponentConfig,
            FieldsComponentRegistry::MODULE_DIRECTORY
        );

        $themeModuleDirectoryReal = realpath($themeModuleDirectory);

        if ($themeModuleDirectoryReal === false) {
            throw new \Exception(
                'Theme module directory is not valid: (' . $themeModuleDirectory . ')'
            );
        }

        $themeName = Param::getRequired(
            $themeComponentConfig,
            FieldsThemeComponentConfig::NAME
        );

        $layoutComponentConfigs = [];

        foreach ($layoutComponentRegistry as $layoutName => $layoutComponentRegistryEntry) {
            $layoutConfigLocation = Param::getRequired(
                $layoutComponentRegistryEntry,
                FieldsComponentRegistry::CONFIG_LOCATION
            );

            $layoutModuleDirectory = Param::getRequired(
                $layoutComponentRegistryEntry,
                FieldsComponentRegistry::MODULE_DIRECTORY
            );

            // Build paths base on theme module
            $layoutConfigLocation = $themeModuleDirectoryReal . $layoutConfigLocation;
            $layoutConfigLocationReal = realpath($layoutConfigLocation);

            $layoutModuleDirectory = $themeModuleDirectoryReal . $layoutModuleDirectory;
            $layoutModuleDirectoryReal = realpath($layoutModuleDirectory);

            if ($layoutConfigLocationReal === false) {
                throw new \Exception(
                    'Layout location not found'
                    . ' for theme: (' . $themeName . ')'
                    . ' layout: (' . $layoutName . ')'
                    . ' location: (' . $layoutConfigLocation . ')'
                );
            }

            if ($layoutModuleDirectoryReal === false) {
                throw new \Exception(
                    'Layout module directory not found'
                    . ' for theme: (' . $themeName . ')'
                    . ' layout: (' . $layoutName . ')'
                    . ' location: (' . $layoutConfigLocation . ')'
                );
            }

            // @todo This does not use the type and component conf reader strategies, expects json file ONLY
            $layoutComponentConfig = $this->readComponentConfig->__invoke($layoutConfigLocationReal);

            $templateFile = Param::getRequired(
                $layoutComponentConfig,
                FieldsLayoutComponentConfig::TEMPLATE_FILE,
                PropertyMissing::buildThrower(
                    FieldsLayoutComponentConfig::TEMPLATE_FILE,
                    $layoutComponentConfig,
                    get_class($this)
                )
            );

            $templateFile = $layoutModuleDirectoryReal . $templateFile;

            $templateFileReal = realpath($templateFile);

            if ($templateFileReal === false) {
                throw new \Exception(
                    'Layout template not found'
                    . ' for theme: (' . $themeName . ')'
                    . ' layout: (' . $layoutName . ')'
                    . ' template: (' . $templateFile . ')'
                );
            }

            $layoutComponentConfig[FieldsLayoutComponent::THEME_NAME] = $themeName;
            $layoutComponentConfig[FieldsComponentConfig::CONFIG_LOCATION] = $layoutConfigLocationReal;
            $layoutComponentConfig[FieldsComponentConfig::MODULE_DIRECTORY] = $layoutModuleDirectoryReal;
            $layoutComponentConfig[FieldsLayoutComponent::HTML] = file_get_contents($templateFileReal);

            $layoutComponentConfigs[] = $layoutComponentConfig;
        }

        $layoutVariations = [];

        foreach ($layoutComponentConfigs as $layoutComponentConfig) {
            $layoutVariations[] = new LayoutComponentBasic(
                'theme-layout',
                Param::getRequired(
                    $layoutComponentConfig,
                    FieldsComponentConfig::NAME
                ),
                Param::getRequired(
                    $layoutComponentConfig,
                    FieldsComponentConfig::CONFIG_LOCATION
                ),
                Param::getRequired(
                    $layoutComponentConfig,
                    FieldsComponentConfig::MODULE_DIRECTORY
                ),
                $layoutComponentConfig,
                Param::get(
                    $layoutComponentConfig,
                    FieldsComponentConfig::CREATED_BY_USER_ID,
                    Trackable::UNKNOWN_USER_ID
                ),
                Param::get(
                    $layoutComponentConfig,
                    FieldsComponentConfig::CREATED_REASON,
                    Trackable::UNKNOWN_REASON
                ),
                Param::get(
                    $layoutComponentConfig,
                    FieldsComponentConfig::CREATED_DATE,
                    null
                )
            );
        }

        $themeComponentConfig[FieldsThemeComponent::LAYOUT_VARIATIONS] = $layoutVariations;

        return $themeComponentConfig;
    }
}
