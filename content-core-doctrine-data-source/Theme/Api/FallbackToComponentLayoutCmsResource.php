<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
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
     * @var VersionFromComponent
     */
    protected $versionFromComponent;

    /**
     * @param FindThemeComponent   $findThemeComponent
     * @param VersionFromComponent $versionFromComponent
     */
    public function __construct(
        FindThemeComponent $findThemeComponent,
        VersionFromComponent $versionFromComponent
    ) {
        $this->findThemeComponent = $findThemeComponent;
        $this->versionFromComponent = $versionFromComponent;
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

        $layoutVersionId
            = 'FALLBACK_VERSION:-:' . $layoutComponent->getThemeName() . ':-:' . $layoutComponent->getName();

        $layoutVersion = $this->versionFromComponent->__invoke(
            $layoutVersionId,
            $layoutComponent
        );

        $properties = [
            PropertiesLayoutCmsResource::ID => $id,
            PropertiesLayoutCmsResource::CONTENT_VERSION => $layoutVersion,
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
