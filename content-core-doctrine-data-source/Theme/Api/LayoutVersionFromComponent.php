<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutComponent;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;

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
            FieldsLayoutVersion::RENDER_TAG_NAME_PARSER => $layoutComponent->getProperty(
                FieldsLayoutVersion::RENDER_TAG_NAME_PARSER
            ),
            FieldsLayoutVersion::RENDERER => $layoutComponent->getProperty(
                FieldsLayoutVersion::RENDERER
            ),
            FieldsLayoutVersion::RENDER_TAGS_GETTER => $layoutComponent->getProperty(
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
