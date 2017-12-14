<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResourceBySitePath implements \Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

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
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = PageCmsResourceEntity::class;
        $this->classCmsResourceBasic = PageCmsResourceBasic::class;

        $this->entityClassContentVersion = PageVersionEntity::class;
        $this->classContentVersionBasic = PageVersionBasic::class;

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $pageCmsResourcePath
     * @param bool   $published
     * @param array  $options
     *
     * @return PageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageCmsResourcePath,
        bool $published = true,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var PageCmsResourceEntity $pageCmsResourceEntity */
        $pageCmsResourceEntity = $repository->findOneBy(
            [
                'siteCmsResourceId' => $siteCmsResourceId,
                'path' => $pageCmsResourcePath,
                'published' => $published
            ]
        );

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $pageCmsResourceEntity,
            $this->contentVersionSyncToProperties
        );
    }
}
