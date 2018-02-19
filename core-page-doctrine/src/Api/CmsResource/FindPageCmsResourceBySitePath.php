<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResourceBySitePath implements \Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath
{
    protected $entityManager;
    protected $entityClassCmsResource;
    protected $classCmsResourceBasic;
    protected $entityClassContentVersion;
    protected $classContentVersionBasic;
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
     * @param string    $siteCmsResourceId
     * @param string    $pageCmsResourcePath
     * @param bool|null $published
     * @param array     $options
     *
     * @return null|CmsResource|PageCmsResource
     * @throws \Exception
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageCmsResourcePath,
        $published = true,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $query = [
            'siteCmsResourceId' => $siteCmsResourceId,
            'path' => $pageCmsResourcePath,
        ];

        if ($published !== null) {
            $query['published'] = (bool)$published;
        }

        /** @var PageCmsResourceEntity $pageCmsResourceEntity */
        $pageCmsResourceEntity = $repository->findOneBy(
            $query
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
