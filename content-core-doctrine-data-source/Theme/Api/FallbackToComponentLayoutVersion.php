<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntitySafe;

/**
 * @todo   REMOVE FALLBACK?
 * @author James Jervis - https://github.com/jerv13
 */
class FallbackToComponentLayoutVersion
{
    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @param FindThemeComponent $findThemeComponent
     */
    public function __construct(
        FindThemeComponent $findThemeComponent
    ) {
        $this->findThemeComponent = $findThemeComponent;
    }

    /**
     * @param LayoutVersion|null $layoutVersion
     * @param string             $id
     * @param array              $options
     *
     * @return LayoutVersion|null
     */
    public function __invoke(
        $layoutVersion,
        string $id,
        array $options = []
    ) {
        if (!empty($layoutVersion)) {
            return $layoutVersion;
        }

        $parts = explode(':-:', $id);
        if ($parts[0] !== 'FALLBACK') {
            return null;
        }

        $themeName = $parts[1];

        $layoutName = $parts[2];

        /** @var ThemeComponent $themeComponent */
        $themeComponent = $this->findThemeComponent->__invoke(
            $themeName
        );

        if (empty($themeComponent)) {
            return null;
        }

        $layoutComponent = $themeComponent->getLayoutVariation(
            $layoutName
        );

        if (empty($layoutComponent)) {
            return null;
        }

        $id = 'FALLBACK_VERSION:-:' . $layoutComponent->getThemeName() . ':-:' . $layoutComponent->getName();

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
