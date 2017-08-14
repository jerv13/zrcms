<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;
use Zrcms\ContentDoctrine\Api\BasicContentVersionTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourceVersionByHost
    extends ApiAbstract
    implements \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceVersionByHost
{
    use BasicCmsResourceTrait;
    use BasicContentVersionTrait;

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
    protected $classContentVersion;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassContentVersion
     * @param string        $classCmsResourceBasic
     * @param string        $classContentVersion
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassContentVersion,
        string $classCmsResourceBasic,
        string $classContentVersion
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResource,
            CmsResource::class
        );

        $this->assertValidEntityClass(
            $entityClassContentVersion,
            ContentVersion::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = SiteCmsResourceEntity::class;
        $this->entityClassContentVersion = SiteVersionEntity::class;
        $this->classCmsResourceBasic = SiteCmsResourceBasic::class;
        $this->classContentVersion = SiteVersionBasic::class;
    }

    public function __invoke(
        string $host,
        array $options = []
    ) {
        $hostPropertyName = PropertiesSiteCmsResource::HOST;

        $queryParams = [
            $host => 'host'
        ];

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource FROM {$this->entityClassCmsResource} resource"
            . " WHERE resource.{$hostPropertyName} = :host"
            . " JOIN {$this->entityClassContentVersion} version WITH resource.contentVersionId =  version.id";

        $dQuery = $this->entityManager->createQuery($query);

        foreach ($queryParams as $value => $queryParam) {
            $dQuery->setParameter($queryParam, $value);
        }

        $cmsResourceVersion = $dQuery->getFirstResult();

        // @todo build classes

        ddd(get_class($this), 'TEST ME', $cmsResourceVersion);

        return $cmsResourceVersion;
    }
}
