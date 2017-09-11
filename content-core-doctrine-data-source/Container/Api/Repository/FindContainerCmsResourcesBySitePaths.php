<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Container\Model\PropertiesContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResourcesBySitePaths
    implements \Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths
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
        $this->entityClassCmsResource = ContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = ContainerCmsResourceBasic::class;

        $this->entityClassContentVersion = ContainerVersionEntity::class;
        $this->classContentVersionBasic = ContainerVersionBasic::class;

        $this->cmsResourceSyncToProperties = [];
        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param array  $containerCmsResourcePaths
     * @param array  $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        array $options = []
    ): array
    {
        $siteCmsResourceIdName = PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID;

        $pathParams = [
            $siteCmsResourceId => 'siteCmsResourceId'
        ];

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT container FROM {$this->entityClassCmsResource} container"
            . " WHERE container.{$siteCmsResourceIdName} = :siteCmsResourceId";

        $query = $this->buildInQuery(
            $containerCmsResourcePaths,
            $query,
            $pathParams
        );

        if (empty($query)) {
            return [];
        }

        $dQuery = $this->entityManager->createQuery($query);
        foreach ($pathParams as $value => $pathParam) {
            $dQuery->setParameter($pathParam, $value);
        }

        $containerCmsResources = $dQuery->getResult();

        return $this->newBasicCmsResources(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $containerCmsResources,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }

    /**
     * @param array  $containerCmsResourcePaths
     * @param string $query
     * @param array  $pathParams
     *
     * @return string
     */
    protected function buildInQuery(
        array $containerCmsResourcePaths,
        string $query,
        array &$pathParams
    ) {
        if (empty($containerCmsResourcePaths)) {
            return '';
        }
        $containerCmsResourcePathName = PropertiesContainerCmsResource::PATH;

        $query = $query . " AND container.{$containerCmsResourcePathName} IN (";

        $cnt = 0;
        $index = 0;
        $length = count($containerCmsResourcePaths);

        foreach ($containerCmsResourcePaths as $containerCmsResourcePath) {
            // avoid duplicates
            if (Param::has($pathParams, $containerCmsResourcePath)) {
                $index++;
                continue;
            }

            $pathParam = 'path' . $cnt;

            $query = $query . ":{$pathParam}";

            $pathParams[$containerCmsResourcePath] = $pathParam;

            $cnt++;
            $index++;
            if ($index < $length) {
                $query = $query . ",";
            }
        }
        $query = $query . ")";

        return $query;
    }
}
