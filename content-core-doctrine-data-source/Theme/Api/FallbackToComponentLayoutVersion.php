<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;

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
     * @var LayoutVersionFromComponent
     */
    protected $versionFromComponent;

    /**
     * @param FindThemeComponent         $findThemeComponent
     * @param LayoutVersionFromComponent $versionFromComponent
     */
    public function __construct(
        FindThemeComponent $findThemeComponent,
        LayoutVersionFromComponent $versionFromComponent
    ) {
        $this->findThemeComponent = $findThemeComponent;
        $this->versionFromComponent = $versionFromComponent;
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

        return $this->versionFromComponent->__invoke(
            $id,
            $layoutComponent
        );
    }
}
