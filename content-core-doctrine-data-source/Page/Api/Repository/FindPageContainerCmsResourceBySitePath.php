<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageContainerCmsResourceBySitePath
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath
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
        $this->entityClassCmsResource = PageContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = PageContainerCmsResourceBasic::class;

        $this->entityClassContentVersion = PageContainerVersionEntity::class;
        $this->classContentVersionBasic = PageContainerVersionBasic::class;

        $this->cmsResourceSyncToProperties = [];
        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param array  $options
     *
     * @return PageContainerCmsResource|CmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var PageContainerCmsResourceEntity $pageContainerCmsResourceEntity */
        $pageContainerCmsResourceEntity = $repository->findOneBy(
            [
                PropertiesPageContainerCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResourceId,
                PropertiesPageContainerCmsResource::PATH => $pageContainerCmsResourcePath,
            ]
        );

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $pageContainerCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
