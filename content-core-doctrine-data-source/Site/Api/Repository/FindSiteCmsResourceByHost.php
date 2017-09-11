<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceByHost
    implements \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost
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
        $this->entityClassCmsResource = SiteCmsResourceEntity::class;
        $this->classCmsResourceBasic = SiteCmsResourceBasic::class;

        $this->entityClassContentVersion = SiteVersionEntity::class;
        $this->classContentVersionBasic = SiteVersionBasic::class;

        $this->cmsResourceSyncToProperties = [];
        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $host
     * @param array  $options
     *
     * @return SiteCmsResource|CmsResource|null
     */
    public function __invoke(
        string $host,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var SiteCmsResourceEntity|CmsResourceEntity $siteCmsResourceEntity */
        $siteCmsResourceEntity = $repository->findOneBy([PropertiesSiteCmsResource::HOST => $host]);

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $siteCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
