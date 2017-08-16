<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceVersionBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceVersionTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceVersionByHost
    extends ApiAbstract
    implements \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceVersionByHost
{
    use BasicCmsResourceVersionTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classCmsResourceBasic;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var
     */
    protected $classCmsResourceVersionBasic;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = SiteCmsResourceEntity::class;
        $this->classCmsResourceBasic = SiteCmsResourceBasic::class;
        $this->entityClassContentVersion = SiteVersionEntity::class;
        $this->classContentVersionBasic = SiteVersionBasic::class;
        $this->classCmsResourceVersionBasic = SiteCmsResourceVersionBasic::class;
    }

    /**
     * @param string $host
     * @param array  $options
     *
     * @return CmsResourceVersion|null
     */
    public function __invoke(
        string $host,
        array $options = []
    ) {
        $hostPropertyName = PropertiesSiteCmsResource::HOST;

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource, version FROM {$this->entityClassCmsResource} resource"
            . " LEFT JOIN {$this->entityClassContentVersion} version"
            . " WITH resource.contentVersionId = version.id"
            . " WHERE resource.{$hostPropertyName} = :host";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('host', $host);

        $result = $dQuery->getResult();

        if (empty($result)) {
            return null;
        }

        return $this->newBasicCmsResourceVersion(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $this->classCmsResourceVersionBasic,
            $result
        );
    }
}
