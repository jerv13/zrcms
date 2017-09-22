<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Fields\FieldsPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResource;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageTemplateCmsResourceBySitePath
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageTemplateCmsResourceBySitePath
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
        $this->entityClassCmsResource = PageTemplateCmsResourceEntity::class;
        $this->classCmsResourceBasic = PageTemplateCmsResourceBasic::class;

        $this->entityClassContentVersion = PageContainerVersionEntity::class;
        $this->classContentVersionBasic = PageContainerVersionBasic::class;

        $this->cmsResourceSyncToProperties = [];
        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $pageTemplateCmsResourcePath
     * @param array  $options
     *
     * @return PageTemplateCmsResource|CmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageTemplateCmsResourcePath,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var PageTemplateCmsResourceEntity $pageTemplateCmsResourceEntity */
        $pageTemplateCmsResourceEntity = $repository->findOneBy(
            [
                FieldsPageTemplateCmsResource::SITE_CMS_RESOURCE_ID => $siteCmsResourceId,
                FieldsPageTemplateCmsResource::PATH => $pageTemplateCmsResourcePath,
            ]
        );

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $pageTemplateCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
