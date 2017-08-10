<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourceVersion
    extends ApiAbstract
    implements \Zrcms\Content\Api\Repository\FindCmsResourceVersion
{
    use BasicCmsResourceTrait;

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
        $this->entityClassCmsResource = $entityClassCmsResource;
        $this->entityClassContentVersion = $entityClassContentVersion;
        $this->classCmsResourceBasic = $classCmsResourceBasic;
        $this->classContentVersion = $classContentVersion;
    }

    /**
     * @param string $cmsResourceId
     * @param array  $options
     *
     * @return void
     */
    public function __invoke(
        string $cmsResourceId,
        array $options = []
    ) {
        $cmsResourceIdName = PropertiesCmsResource::ID;

        $queryParams = [
            $cmsResourceId=> 'cmsResourceId'
        ];

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource FROM {$this->entityClassCmsResource} resource"
            . " WHERE resource.{$cmsResourceIdName} = :cmsResourceId"
            . " JOIN {$this->entityClassContentVersion} version WITH resource.contentVersionId =  version.id";


        $dQuery = $this->entityManager->createQuery($query);

        foreach ($queryParams as $value => $queryParam) {
            $dQuery->setParameter($queryParam, $value);
        }

        $cmsResourceVersion = $dQuery->getFirstResult();

        ddd($cmsResourceVersion);
    }
}
