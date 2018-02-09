<?php

namespace Zrcms\CoreTheme\Api\Component;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponent;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponentConfig;
use Zrcms\CoreTheme\Model\LayoutComponentBasic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectThemeLayout implements BuildComponentObject
{
    /**
     * @param array $layoutComponentConfig
     * @param array $options
     *
     * @return Component
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __invoke(
        array $layoutComponentConfig,
        array $options = []
    ): Component {
        $layoutModuleDirectory = Property::getRequired(
            $layoutComponentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $templateFile = Property::getRequired(
            $layoutComponentConfig,
            FieldsLayoutComponentConfig::TEMPLATE_FILE,
            get_class($this)
        );

        $layoutModuleDirectoryReal = realpath($layoutModuleDirectory);

        $templateFile = $layoutModuleDirectoryReal . $templateFile;

        $templateFileReal = realpath($templateFile);

        $layoutComponentConfig[FieldsLayoutComponent::HTML] = file_get_contents($templateFileReal);

        return new LayoutComponentBasic(
            'theme-layout',
            Property::getRequired(
                $layoutComponentConfig,
                FieldsComponentConfig::NAME
            ),
            Property::getRequired(
                $layoutComponentConfig,
                FieldsComponentConfig::CONFIG_URI
            ),
            Property::getRequired(
                $layoutComponentConfig,
                FieldsComponentConfig::MODULE_DIRECTORY
            ),
            $layoutComponentConfig,
            Property::get(
                $layoutComponentConfig,
                FieldsComponentConfig::CREATED_BY_USER_ID,
                Trackable::UNKNOWN_USER_ID
            ),
            Property::get(
                $layoutComponentConfig,
                FieldsComponentConfig::CREATED_REASON,
                Trackable::UNKNOWN_REASON
            ),
            Property::get(
                $layoutComponentConfig,
                FieldsComponentConfig::CREATED_DATE,
                null
            )
        );
    }
}
