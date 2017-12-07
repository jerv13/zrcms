<?php

namespace Zrcms\CoreThemeDoctrine\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\ThemeComponent;

/**
 * @todo   REMOVE FALLBACK?
 * @author James Jervis - https://github.com/jerv13
 */
class FallbackToComponentLayoutCmsResource
{
    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @var LayoutVersionFromComponent
     */
    protected $versionFromComponent;

    /**
     * @param FindComponent              $findComponent
     * @param LayoutVersionFromComponent $versionFromComponent
     */
    public function __construct(
        FindComponent $findComponent,
        LayoutVersionFromComponent $versionFromComponent
    ) {
        $this->findComponent = $findComponent;
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
        $themeComponent = $this->findComponent->__invoke(
            'theme',
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

        return new LayoutCmsResourceBasic(
            $id,
            true,
            $layoutVersion,
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason(),
            $layoutComponent->getCreatedDate()
        );
    }
}
