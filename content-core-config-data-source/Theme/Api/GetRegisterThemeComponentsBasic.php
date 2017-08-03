<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Model\LayoutComponentBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutComponent;
use Zrcms\ContentCore\Theme\Model\PropertiesThemeComponent;
use Zrcms\ContentCore\Theme\Model\ThemeComponentBasic;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetRegisterComponentsAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Theme\Model\LayoutComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Theme\Model\ThemeComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Theme\Model\ThemeComponentRegistryFields;
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
     * @param array                     $registryConfig
     * @param ReadThemeComponentConfig  $readComponentConfig
     * @param ReadLayoutComponentConfig $readLayoutComponentConfig
     * @param Cache                     $cache
     * @param string                    $componentClass
     * @param string                    $cacheKey
     */
    public function __construct(
        array $registryConfig,
        ReadThemeComponentConfig $readComponentConfig,
        ReadLayoutComponentConfig $readLayoutComponentConfig,
        Cache $cache,
        string $componentClass = ThemeComponentBasic::class,
        string $cacheKey = self::CACHE_KEY
    ) {
        $this->readLayoutComponentConfig = $readLayoutComponentConfig;
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
     * @throws \Exception
     */
    protected function buildSubComponents(array $themeComponentConfig): array
    {
        $layoutConfigLocations = Param::getArray(
            $themeComponentConfig,
            ThemeComponentConfigFields::LAYOUT_LOCATIONS,
            []
        );

        $themeLocation = Param::getRequired(
            $themeComponentConfig,
            ThemeComponentRegistryFields::CONFIG_LOCATION
        );

        $themeName = Param::getRequired(
            $themeComponentConfig,
            ThemeComponentConfigFields::NAME
        );

        $layoutComponentConfigs = [];

        // @todo We should use a GetRegisterComponents for layout so it is supports the same formats
        foreach ($layoutConfigLocations as $layoutName => $layoutConfigLocation) {

            // Add theme location to layout location
            $layoutLocation = $themeLocation . $layoutConfigLocation;

            $realLayoutLocation = realpath($layoutLocation);

            if (empty($layoutLocation) || !file_exists($realLayoutLocation)) {
                throw new \Exception('Layout location not found for ' . $layoutLocation);
            }

            $layoutComponentConfig = $this->readLayoutComponentConfig->__invoke($realLayoutLocation);

            $layoutComponentConfig[PropertiesLayoutComponent::THEME_NAME] = $themeName;

            $templateFile = Param::getRequired(
                $layoutComponentConfig,
                LayoutComponentConfigFields::TEMPLATE_FILE,
                PropertyMissingException::build(
                    LayoutComponentConfigFields::TEMPLATE_FILE,
                    $layoutComponentConfig,
                    get_class($this)
                )
            );

            $templateFile = $realLayoutLocation . '/' . $templateFile;

            $realTemplateFile = realpath($templateFile);

            if (empty($realTemplateFile) || !file_exists($realTemplateFile)) {
                throw new \Exception('Layout template not found for ' . $templateFile);
            }

            $layoutComponentConfig[PropertiesLayoutComponent::HTML] = file_get_contents($realTemplateFile);

            $layoutComponentConfigs[] = $layoutComponentConfig;
        }

        $layoutVariations = [];

        foreach ($layoutComponentConfigs as $layoutComponentConfig) {

            $layoutVariations[] = new LayoutComponentBasic(
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
