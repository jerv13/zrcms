<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResources;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResourcesBySitePaths
    implements \Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths
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
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = ContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = ContainerCmsResourceBasic::class;

        $this->entityClassContentVersion = ContainerVersionEntity::class;
        $this->classContentVersionBasic = ContainerVersionBasic::class;

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param array  $containerCmsResourcePaths
     * @param bool   $published
     * @param array  $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        bool $published = true,
        array $options = []
    ): array
    {
        $pathParams = [];

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT container FROM {$this->entityClassCmsResource} container"
            . " WHERE container.siteCmsResourceId = :containerSiteCmsResourceId"
            . " AND container.published = :containerPublished";

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

        $dQuery->setParameter('containerSiteCmsResourceId', $siteCmsResourceId);
        $dQuery->setParameter('containerPublished', $published);

        $containerCmsResources = $dQuery->getResult();

        return BuildBasicCmsResources::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $containerCmsResources,
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

        $query = $query . " AND container.path IN (";

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
