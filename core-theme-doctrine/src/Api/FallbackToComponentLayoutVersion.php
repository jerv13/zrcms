<?php

namespace Zrcms\CoreThemeDoctrine\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreTheme\Model\LayoutVersion;
use Zrcms\CoreTheme\Model\ThemeComponent;

/**
 * @todo   REMOVE FALLBACK?
 * @author James Jervis - https://github.com/jerv13
 */
class FallbackToComponentLayoutVersion
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
     * @param FindComponent         $findComponent
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

        $id = 'FALLBACK_VERSION:-:' . $layoutComponent->getThemeName() . ':-:' . $layoutComponent->getName();

        return $this->versionFromComponent->__invoke(
            $id,
            $layoutComponent
        );
    }
}
