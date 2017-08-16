<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\PropertiesLayoutCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Api\FallbackToComponentLayoutCmsResource;
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

        $layoutCmsResource = $this->newBasicCmsResource(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $layoutCmsResource
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
