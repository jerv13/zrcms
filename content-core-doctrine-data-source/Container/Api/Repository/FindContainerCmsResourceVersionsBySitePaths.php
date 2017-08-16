<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceVersionBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCore\Container\Model\PropertiesContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceVersionTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResourceVersionsBySitePaths
    implements \Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourceVersionsBySitePaths
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
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = ContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = ContainerCmsResourceBasic::class;
        $this->entityClassContentVersion = ContainerVersionEntity::class;
        $this->classContentVersionBasic = ContainerVersionBasic::class;
        $this->classCmsResourceVersionBasic = ContainerCmsResourceVersionBasic::class;
    }

    /**
     * @param string $cmsResourceId
     * @param array  $cmsResourcePaths
     * @param array  $options
     *
     * @return ContainerCmsResourceVersion[]
     */
    public function __invoke(
        string $cmsResourceId,
        array $cmsResourcePaths,
        array $options = []
    ): array
    {
        $cmsResourceIdName = PropertiesContainerCmsResource::SITE_CMS_RESOURCE_ID;

        $pathParams = [
            $cmsResourceId => 'cmsResourceId'
        ];

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource, version FROM {$this->entityClassCmsResource} resource"
            . " LEFT JOIN {$this->entityClassContentVersion} version"
            . " WITH resource.contentVersionId = version.id"
            . " WHERE resource.{$cmsResourceIdName} = :cmsResourceId";

        $query = $this->buildInQuery(
            $cmsResourcePaths,
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

        $results = $dQuery->getResult();

        return $this->newBasicCmsResourceVersions(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $this->classCmsResourceVersionBasic,
            $results
        );
    }

    /**
     * @param array  $cmsResourcePaths
     * @param string $query
     * @param array  $pathParams
     *
     * @return string
     */
    protected function buildInQuery(
        array $cmsResourcePaths,
        string $query,
        array &$pathParams
    ) {
        if (empty($cmsResourcePaths)) {
            return '';
        }
        $cmsResourcePathName = PropertiesContainerCmsResource::PATH;

        $query = $query . " AND resource.{$cmsResourcePathName} IN (";

        $cnt = 0;
        $index = 0;
        $length = count($cmsResourcePaths);

        foreach ($cmsResourcePaths as $cmsResourcePath) {
            // avoid duplicates
            if (Param::has($pathParams, $cmsResourcePath)) {
                $index++;
                continue;
            }

            $pathParam = 'path' . $cnt;

            $query = $query . ":{$pathParam}";

            $pathParams[$cmsResourcePath] = $pathParam;

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
