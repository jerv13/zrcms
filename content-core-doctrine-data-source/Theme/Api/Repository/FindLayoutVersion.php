<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutVersion;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion
{
    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @param EntityManager      $entityManager
     * @param FindThemeComponent $findThemeComponent
     */
    public function __construct(
        EntityManager $entityManager,
        FindThemeComponent $findThemeComponent
    ) {
        $this->findThemeComponent = $findThemeComponent;

        parent::__construct(
            $entityManager,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return LayoutVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        /** @var LayoutVersion $layoutVersion */
        $layoutVersion = parent::__invoke(
            $id,
            $options
        );

        return $this->fallBackToComponent(
            $layoutVersion,
            $id,
            $options
        );
    }

    /**
     * @todo REMOVE FALLBACK?
     *
     * @param LayoutVersion|null $layoutVersion
     * @param string             $id
     * @param array              $options
     *
     * @return LayoutVersion|null
     */
    protected function fallBackToComponent(
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

        /** @var ThemeComponent $theme */
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

        return new LayoutVersionBasic(
            [
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
            ],
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
