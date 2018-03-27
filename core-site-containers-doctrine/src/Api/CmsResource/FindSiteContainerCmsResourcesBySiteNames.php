<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResources;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames as ParentFindByNames;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerCmsResourceEntity;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteContainerCmsResourcesBySiteNames implements ParentFindByNames
{
    protected $entityManager;
    protected $entityClassCmsResource;
    protected $classCmsResourceBasic;
    protected $entityClassContentVersion;
    protected $classContentVersionBasic;
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = SiteContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = ContainerCmsResourceBasic::class;

        $this->entityClassContentVersion = SiteContainerVersionEntity::class;
        $this->classContentVersionBasic = ContainerVersionBasic::class;

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string    $siteCmsResourceId
     * @param array     $containerCmsResourceNames
     * @param bool|null $published
     * @param array     $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourceNames,
        $published = true,
        array $options = []
    ): array {
        $nameParams = [];

        // @todo Add prepared statements not concat
        $query
            = "SELECT container FROM {$this->entityClassCmsResource} container"
            . " WHERE container.siteCmsResourceId = :containerSiteCmsResourceId";

        if (is_bool($published)) {
            $query .= " AND container.published = :containerPublished";
        }

        $query = $this->buildInQuery(
            $containerCmsResourceNames,
            $query,
            $nameParams
        );

        if (empty($query)) {
            return [];
        }

        $dQuery = $this->entityManager->createQuery($query);
        foreach ($nameParams as $value => $nameParam) {
            $dQuery->setParameter($nameParam, $value);
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
     * @param array  $containerCmsResourceNames
     * @param string $query
     * @param array  $nameParams
     *
     * @return string
     */
    protected function buildInQuery(
        array $containerCmsResourceNames,
        string $query,
        array &$nameParams
    ) {
        if (empty($containerCmsResourceNames)) {
            return '';
        }

        $query = $query . " AND container.name IN (";

        $cnt = 0;
        $index = 0;
        $length = count($containerCmsResourceNames);

        foreach ($containerCmsResourceNames as $containerCmsResourceName) {
            // avoid duplicates
            if (Property::has($nameParams, $containerCmsResourceName)) {
                $index++;
                continue;
            }

            $nameParam = 'name' . $cnt;

            $query = $query . ":{$nameParam}";

            $nameParams[$containerCmsResourceName] = $nameParam;

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
