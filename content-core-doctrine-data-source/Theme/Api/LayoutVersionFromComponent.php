<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Model\LayoutComponent;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntitySafe;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class VersionFromComponent
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
            PropertiesLayoutVersion::ID => $id,
            PropertiesLayoutVersion::NAME => $layoutComponent->getName(),
            PropertiesLayoutVersion::THEME_NAME => $layoutComponent->getThemeName(),
            PropertiesLayoutVersion::HTML => $layoutComponent->getHtml(),
            PropertiesLayoutVersion::RENDER_TAGS_GETTER => $layoutComponent->getProperty(
                PropertiesLayoutVersion::RENDER_TAGS_GETTER
            ),
            PropertiesLayoutVersion::RENDER_TAG_NAME_PARSER => $layoutComponent->getProperty(
                PropertiesLayoutVersion::RENDER_TAG_NAME_PARSER
            ),
            PropertiesLayoutVersion::RENDERER => $layoutComponent->getProperty(
                PropertiesLayoutVersion::RENDERER
            ),
            PropertiesLayoutVersion::RENDER_TAGS_GETTER => $layoutComponent->getProperty(
                PropertiesLayoutVersion::RENDER_TAGS_GETTER
            ),
        ];

        return new LayoutVersionEntitySafe(
            $properties,
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
