<?php

namespace Zrcms\CoreThemeDoctrine\Api;

use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Zrcms\CoreTheme\Model\LayoutComponent;
use Zrcms\CoreTheme\Model\LayoutVersion;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutVersionFromComponent
{
    /**
     * @param string          $id
     * @param LayoutComponent $layoutComponent
     *
     * @return LayoutVersion
     */
    public function __invoke(
        string $id,
        LayoutComponent $layoutComponent
    ) {
        $properties = [
            FieldsLayoutVersion::NAME => $layoutComponent->getName(),
            FieldsLayoutVersion::THEME_NAME => $layoutComponent->getThemeName(),
            FieldsLayoutVersion::HTML => $layoutComponent->getHtml(),
            FieldsLayoutVersion::RENDER_TAG_NAME_PARSER => $layoutComponent->findProperty(
                FieldsLayoutVersion::RENDER_TAG_NAME_PARSER
            ),
            FieldsLayoutVersion::RENDERER => $layoutComponent->findProperty(
                FieldsLayoutVersion::RENDERER
            ),
            FieldsLayoutVersion::RENDER_TAGS_GETTER => $layoutComponent->findProperty(
                FieldsLayoutVersion::RENDER_TAGS_GETTER
            ),
        ];

        return new LayoutVersionBasic(
            $id,
            $properties,
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
