<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceByHost
    implements \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = SiteCmsResourceEntity::class;
        $this->classCmsResourceBasic = SiteCmsResourceBasic::class;
    }

    /**
     * @param string $host
     * @param array  $options
     *
     * @return SiteCmsResource|null
     */
    public function __invoke(
        string $host,
        array $options = []
    ) {
        // @todo
    }
}
