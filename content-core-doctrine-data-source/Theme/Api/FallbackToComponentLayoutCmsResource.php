<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntitySafe;

/**
 * @todo   REMOVE FALLBACK?
 * @author James Jervis - https://github.com/jerv13
 */
class FallbackToComponentLayoutCmsResource
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
     *
     *
     * @param LayoutCmsResource|null $layoutCmsResource
     * @param string                 $themeName
     * @param string                 $layoutName
     * @param array                  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        $layoutCmsResource,
        string $themeName,
        string $layoutName,
        array $options = []
    ) {
        if (!empty($layoutCmsResource)) {
            return $layoutCmsResource;
        }

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

        $id = 'FALLBACK:-:' . $layoutComponent->getThemeName() . ':-:' . $layoutComponent->getName();

        $properties = [
            PropertiesLayoutCmsResource::ID => $id,
            PropertiesLayoutCmsResource::CONTENT_VERSION_ID => $id,
            PropertiesLayoutCmsResource::NAME => $layoutComponent->getName(),
            PropertiesLayoutCmsResource::THEME_NAME => $layoutComponent->getThemeName(),
        ];

        return new LayoutCmsResourceEntitySafe(
            $properties,
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
