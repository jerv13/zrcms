<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Component;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\GetRegisterComponentsAbstract;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Api\Component\GetRegisterThemeComponents;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponent;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutComponentBasic;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCore\Theme\Model\ThemeComponentBasic;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\Component\ReadThemeComponentRegistryBasic;
use Zrcms\ContentCoreConfigDataSource\Theme\Fields\FieldsThemeComponentRegistry;
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
     * @var ReadLayoutComponentConfig
     */
    protected $readLayoutComponentConfig;

    /**
     * @param ReadThemeComponentRegistryBasic $readComponentRegistry
     * @param ReadLayoutComponentConfig       $readLayoutComponentConfig
     * @param Cache                           $cache
     * @param string                          $cacheKey
     */
    public function __construct(
        ReadThemeComponentRegistryBasic $readComponentRegistry,
        ReadLayoutComponentConfig $readLayoutComponentConfig,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->readLayoutComponentConfig = $readLayoutComponentConfig;

        parent::__construct(
            $readComponentRegistry,
            $cache,
            $cacheKey,
            ThemeComponentBasic::class,
            ThemeComponent::class
        );
    }

    /**
     * @todo This should be in the ReadLayoutComponentRegistry
     *
     * @param array $themeComponentConfig
     *
     * @return array
     * @throws \Exception
     */
    protected function buildSubComponents(array $themeComponentConfig): array
    {
        $layoutConfigLocations = Param::getArray(
            $themeComponentConfig,
            FieldsThemeComponentConfig::LAYOUT_LOCATIONS,
            []
        );

        $themeLocation = Param::getRequired(
            $themeComponentConfig,
            FieldsThemeComponentRegistry::CONFIG_LOCATION
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

            $layoutComponentConfig = $this->readLayoutComponentConfig->__invoke($realLayoutLocation);

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
