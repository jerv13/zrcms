<?php

namespace Zrcms\ContentCore\Theme\Api\Component;

use Zrcms\Content\Api\Component\PrepareComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Fields\FieldsComponentRegistry;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponent;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponent;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponentConfig;
use Zrcms\ContentCore\Theme\Model\LayoutComponentBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareComponentConfigThemeLayouts implements PrepareComponentConfig
{
    protected $readComponentConfig;

    /**
     * @todo JSON is the only expected reader, this forces the JSON format, this should be addressed
     * @param ReadComponentConfig|ReadComponentConfigJsonFile $readComponentConfig
     */
    public function __construct(
        ReadComponentConfig $readComponentConfig
    ) {
        $this->readComponentConfig = $readComponentConfig;
    }

    /**
     * @param array $themeComponentConfig
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $themeComponentConfig,
        array $options = []
    ):array
    {
        $layoutConfigLocations = Param::getArray(
            $themeComponentConfig,
            FieldsThemeComponentConfig::LAYOUT_LOCATIONS,
            []
        );

        $themeLocation = Param::getRequired(
            $themeComponentConfig,
            FieldsComponentRegistry::CONFIG_LOCATION
        );

        $themeName = Param::getRequired(
            $themeComponentConfig,
            FieldsThemeComponentConfig::NAME
        );

        $layoutComponentConfigs = [];

        // @todo We should use a ReadLayoutComponentRegistry for layout so it is supports the same formats
        foreach ($layoutConfigLocations as $layoutName => $layoutConfigLocation) {

            // Add theme location to layout location
            $layoutLocation = $themeLocation . $layoutConfigLocation;

            $realLayoutLocation = realpath($layoutLocation);

            if (empty($layoutLocation) || !file_exists($realLayoutLocation)) {
                throw new \Exception('Layout location not found for ' . $layoutLocation);
            }

            $layoutComponentConfig = $this->readComponentConfig->__invoke($realLayoutLocation);

            $layoutComponentConfig[FieldsLayoutComponent::THEME_NAME] = $themeName;

            $templateFile = Param::getRequired(
                $layoutComponentConfig,
                FieldsLayoutComponentConfig::TEMPLATE_FILE,
                PropertyMissing::buildThrower(
                    FieldsLayoutComponentConfig::TEMPLATE_FILE,
                    $layoutComponentConfig,
                    get_class($this)
                )
            );

            $templateFile = $realLayoutLocation . '/' . $templateFile;

            $realTemplateFile = realpath($templateFile);

            if (empty($realTemplateFile) || !file_exists($realTemplateFile)) {
                throw new \Exception('Layout template not found for ' . $templateFile);
            }

            $layoutComponentConfig[FieldsLayoutComponent::HTML] = file_get_contents($realTemplateFile);

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
                )
            );
        }

        $themeComponentConfig[FieldsThemeComponent::LAYOUT_VARIATIONS] = $layoutVariations;

        return $themeComponentConfig;
    }
}
