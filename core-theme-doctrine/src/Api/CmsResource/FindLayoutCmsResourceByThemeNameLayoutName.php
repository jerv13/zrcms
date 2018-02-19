<?php

namespace Zrcms\CoreThemeDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName as CoreFind;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutCmsResource;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourceByThemeNameLayoutName implements CoreFind
{
    protected $entityManager;
    protected $fallbackToComponentLayoutCmsResource;
    protected $entityClassCmsResource;
    protected $classCmsResourceBasic;
    protected $entityClassContentVersion;
    protected $classContentVersionBasic;
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager                        $entityManager
     * @param FallbackToComponentLayoutCmsResource $fallbackToComponentLayoutCmsResource
     */
    public function __construct(
        EntityManager $entityManager,
        FallbackToComponentLayoutCmsResource $fallbackToComponentLayoutCmsResource
    ) {
        $this->entityManager = $entityManager;
        $this->fallbackToComponentLayoutCmsResource = $fallbackToComponentLayoutCmsResource;
        $this->entityClassCmsResource = LayoutCmsResourceEntity::class;
        $this->classCmsResourceBasic = LayoutCmsResourceBasic::class;

        $this->entityClassContentVersion = LayoutVersionEntity::class;
        $this->classContentVersionBasic = LayoutVersionBasic::class;

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string    $themeName
     * @param string    $layoutName
     * @param bool|null $published
     * @param array     $options
     *
     * @return null|CmsResource|LayoutCmsResource
     * @throws \Exception
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        $published = true,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var LayoutCmsResourceEntity $layoutCmsResourceEntity */
        $layoutCmsResourceEntity = $repository->findOneBy(
            [
                'themeName' => $themeName,
                'name' => $layoutName,
                'published' => $published
            ]
        );

        /** @var LayoutCmsResource $layoutCmsResource */
        $layoutCmsResource = BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $layoutCmsResourceEntity,
            $this->contentVersionSyncToProperties
        );

        // @todo REMOVE FALLBACK?
        return $this->fallbackToComponentLayoutCmsResource->__invoke(
            $layoutCmsResource,
            $themeName,
            $layoutName,
            $options
        );
    }
}
