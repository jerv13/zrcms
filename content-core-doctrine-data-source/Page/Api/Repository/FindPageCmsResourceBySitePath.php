<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCore\Page\Fields\FieldsPageCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResourceBySitePath
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageCmsResourceBySitePath
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
    protected $cmsResourceSyncToProperties = [];

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

        $this->cmsResourceSyncToProperties = [];
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
                FieldsPageCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResourceId,
                FieldsPageCmsResource::PATH => $pageCmsResourcePath,
                'published' => $published
            ]
        );

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $pageCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
