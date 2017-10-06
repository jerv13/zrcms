<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Fields\FieldsSiteCmsResource;
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
     * @todo Implement an expiration for long running services
     *
     * @var array
     */
    protected $cache = [];

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
     * @param bool   $published
     * @param array  $options
     *
     * @return SiteCmsResource|CmsResource
     */
    public function __invoke(
        string $host,
        bool $published = true,
        array $options = []
    ) {
        // basic caching
        if (array_key_exists($host, $this->cache)) {
            return $this->cache[$host];
        }

        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var SiteCmsResourceEntity|CmsResourceEntity $siteCmsResourceEntity */
        $siteCmsResourceEntity = $repository->findOneBy(
            [
                FieldsSiteCmsResource::HOST => $host,
                'published' => $published,
            ]
        );

        $siteCmsResource = BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $siteCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );

        $this->cache[$host] = $siteCmsResource;

        return $siteCmsResource;
    }
}
