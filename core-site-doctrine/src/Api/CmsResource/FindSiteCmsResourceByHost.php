<?php

namespace Zrcms\CoreSiteDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Reliv\CacheRat\Service\Cache;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceByHost implements \Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost
{
    const CACHE_KEY = 'FindSiteCmsResourceByHost';
    const CACHE_TTL = 30;

    protected $entityManager;
    protected $entityClassCmsResource;
    protected $classCmsResourceBasic;
    protected $entityClassContentVersion;
    protected $classContentVersionBasic;
    protected $contentVersionSyncToProperties = [];
    protected $cache;
    protected $cacheKey;
    protected $cacheTtl;

    /**
     * @param EntityManager $entityManager
     * @param Cache         $cache
     * @param string        $cacheKey
     * @param int           $cacheTtl
     */
    public function __construct(
        EntityManager $entityManager,
        Cache $cache,
        string $cacheKey = self::CACHE_KEY,
        int $cacheTtl = self::CACHE_TTL
    ) {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->cacheTtl = $cacheTtl;

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
     * @return mixed|null|CmsResource|SiteCmsResource
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        string $host,
        $published = true,
        array $options = []
    ) {
        if ($this->hasCache($host)) {
            return $this->getCache($host);
        }

        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $query = [
            'host' => $host,
        ];

        if ($published !== null) {
            $query['published'] = (bool)$published;
        }

        /** @var SiteCmsResourceEntity|CmsResourceEntity $siteCmsResourceEntity */
        $siteCmsResourceEntity = $repository->findOneBy(
            $query
        );

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $siteCmsResourceEntity,
            $this->contentVersionSyncToProperties
        );

        if (empty($siteCmsResource)) {
            return null;
        }

        $this->setCache($host, $siteCmsResource);

        return $siteCmsResource;
    }

    /**
     * @param string $host
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache(string $host)
    {
        $cache = $this->cache->get($this->cacheKey);

        if (empty($cache)) {
            return false;
        }

        return array_key_exists($host, $cache);
    }

    /**
     * @param string $host
     *
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache(string $host)
    {
        if (!$this->hasCache($host)) {
            return null;
        }

        $cache = $this->cache->get($this->cacheKey);

        return unserialize($cache[$host]);
    }

    /**
     * @param string          $host
     * @param SiteCmsResource $siteCmsResource
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache(
        string $host,
        SiteCmsResource $siteCmsResource
    ) {
        $cache = $this->cache->get($this->cacheKey);

        if (!is_array($cache)) {
            $cache = [];
        }

        $cache[$host] = serialize($siteCmsResource);

        $this->cache->set($this->cacheKey, $cache, $this->cacheTtl);
    }
}
