<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourceByThemeNameLayoutName
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FindThemeComponent
     */
    protected $findThemeComponent;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager      $entityManager
     * @param FindThemeComponent $findThemeComponent
     */
    public function __construct(
        EntityManager $entityManager,
        FindThemeComponent $findThemeComponent
    ) {
        $this->entityManager = $entityManager;
        $this->findThemeComponent = $findThemeComponent;
        $this->entityClassCmsResource = LayoutCmsResourceEntity::class;
        $this->classCmsResourceBasic = LayoutCmsResourceBasic::class;
    }

    /**
     * @param string $themeName
     * @param string $layoutName
     * @param array  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = $repository->findOneBy(
            [
                PropertiesLayoutCmsResource::THEME_NAME => $themeName,
                PropertiesLayoutCmsResource::NAME => $layoutName,
            ]
        );

        return $this->fallBackToComponent(
            $layoutCmsResource,
            $themeName,
            $layoutName,
            $options
        );
    }

    /**
     * @todo REMOVE FALLBACK?
     *
     * @param LayoutCmsResource|null $layoutCmsResource
     * @param string                 $themeName
     * @param string                 $layoutName
     * @param array                  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    protected function fallBackToComponent(
        $layoutCmsResource,
        string $themeName,
        string $layoutName,
        array $options = []
    ) {
        if (!empty($layoutCmsResource)) {
            return $this->newBasicCmsResource(
                $this->entityClassCmsResource,
                $this->classCmsResourceBasic,
                $layoutCmsResource
            );
        }

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

        $id = 'FALLBACK:-:' . $layoutComponent->getThemeName() . ':-:' . $layoutComponent->getName();

        return new LayoutCmsResourceBasic(
            [
                PropertiesLayoutCmsResource::ID => $id,
                PropertiesLayoutCmsResource::CONTENT_VERSION_ID => $id,
                PropertiesLayoutCmsResource::NAME => $layoutComponent->getName(),
                PropertiesLayoutCmsResource::THEME_NAME => $layoutComponent->getThemeName(),
            ],
            $layoutComponent->getCreatedByUserId(),
            $layoutComponent->getCreatedReason()
        );
    }
}
