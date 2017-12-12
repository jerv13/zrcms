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
use Zrcms\Param\Param;

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
     */
    public function __invoke(
        array $layoutComponentConfig,
        array $options = []
    ): Component {
        $layoutModuleDirectory = Param::getRequired(
            $layoutComponentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $templateFile = Param::getRequired(
            $layoutComponentConfig,
            FieldsLayoutComponentConfig::TEMPLATE_FILE,
            PropertyMissing::buildThrower(
                FieldsLayoutComponentConfig::TEMPLATE_FILE,
                $layoutComponentConfig,
                get_class($this)
            )
        );

        $layoutModuleDirectoryReal = realpath($layoutModuleDirectory);

        $templateFile = $layoutModuleDirectoryReal . $templateFile;

        $templateFileReal = realpath($templateFile);

        $layoutComponentConfig[FieldsLayoutComponent::HTML] = file_get_contents($templateFileReal);

        return new LayoutComponentBasic(
            'theme-layout',
            Param::getRequired(
                $layoutComponentConfig,
                FieldsComponentConfig::NAME
            ),
            Param::getRequired(
                $layoutComponentConfig,
                FieldsComponentConfig::CONFIG_URI
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
}
