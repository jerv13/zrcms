<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceVersion;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceVersionBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceVersionTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageContainerCmsResourceVersionBySitePath
    extends ApiAbstract
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceVersionBySitePath
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
        $this->entityClassCmsResource = PageContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = PageContainerCmsResourceBasic::class;
        $this->entityClassContentVersion = PageContainerVersionEntity::class;
        $this->classContentVersionBasic = PageContainerVersionBasic::class;
        $this->classCmsResourceVersionBasic = PageContainerCmsResourceVersionBasic::class;
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param array  $options
     *
     * @return PageContainerCmsResourceVersion|CmsResourceVersion|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        array $options = []
    ) {
        $cmsResourcePropertyName = PropertiesPageContainerCmsResource::ID;
        $pathPropertyName = PropertiesPageContainerCmsResource::PATH;

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource, version FROM {$this->entityClassCmsResource} resource"
            . " LEFT JOIN {$this->entityClassContentVersion} version"
            . " WITH resource.contentVersionId = version.id"
            . " WHERE resource.{$cmsResourcePropertyName} = :cmsResourceId"
            . " AND resource.{$pathPropertyName} = :path";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('cmsResourceId', $siteCmsResourceId);
        $dQuery->setParameter('path', $pageContainerCmsResourcePath);

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
