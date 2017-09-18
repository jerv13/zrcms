<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Model\LayoutComponent;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntitySafe;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutVersionFromComponent
{
    /**
     * @param string          $id
     * @param LayoutComponent $layoutComponent
     *
     * @return LayoutVersionEntitySafe
     */
    public function __invoke(
        string $id,
        LayoutComponent $layoutComponent
    ) {
        $properties = [
            FieldsLayoutVersion::ID => $id,
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

        return new LayoutVersionEntitySafe(
            $properties,
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
