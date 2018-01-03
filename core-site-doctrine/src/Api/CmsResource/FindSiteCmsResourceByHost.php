<?php

namespace Zrcms\CoreSiteDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceByHost implements \Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost
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

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $host
     * @param bool   $published
     * @param array  $options
     *
     * @return null|CmsResource|SiteCmsResource
     * @throws \Exception
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
                'host' => $host,
                'published' => $published,
            ]
        );

        $siteCmsResource = BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $siteCmsResourceEntity,
            $this->contentVersionSyncToProperties
        );

        $this->cache[$host] = $siteCmsResource;

        return $siteCmsResource;
    }
}
