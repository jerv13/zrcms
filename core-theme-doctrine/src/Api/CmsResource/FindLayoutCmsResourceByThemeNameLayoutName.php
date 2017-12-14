<?php

namespace Zrcms\CoreThemeDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutCmsResource;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourceByThemeNameLayoutName implements \Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FallbackToComponentLayoutCmsResource
     */
    protected $fallbackToComponentLayoutCmsResource;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var array
     */
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
     * @param string $themeName
     * @param string $layoutName
     * @param bool   $published
     * @param array  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        bool $published = true,
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
