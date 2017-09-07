<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceVersionTrait;
use Zrcms\ContentRedirect\Model\PropertiesRedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceVersion;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceVersionBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * Find published CmsResource by site and request path
 *
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourceVersionBySiteRequestPath
    extends ApiAbstract
    implements \Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceVersionBySiteRequestPath
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
        $this->entityClassCmsResource = RedirectCmsResourceEntity::class;
        $this->classCmsResourceBasic = RedirectCmsResourceBasic::class;
        $this->entityClassContentVersion = RedirectVersionEntity::class;
        $this->classContentVersionBasic = RedirectVersionBasic::class;
        $this->classCmsResourceVersionBasic = RedirectCmsResourceVersionBasic::class;
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $requestPath
     * @param array  $options
     *
     * @return RedirectCmsResourceVersion|CmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $requestPath,
        array $options = []
    ) {
        $siteCmsResourceIdPropertyName = PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID;
        $requestPathPropertyName = PropertiesRedirectCmsResource::REQUEST_PATH;
        $publishedPropertyName = PropertiesRedirectCmsResource::PUBLISHED;

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource, version FROM {$this->entityClassCmsResource} resource"
            . " LEFT JOIN {$this->entityClassContentVersion} version"
            . " WITH resource.contentVersionId = version.id"
            . " WHERE (resource.{$siteCmsResourceIdPropertyName} = :siteCmsResource"
            . " OR resource.{$siteCmsResourceIdPropertyName} IS NULL)"
            . " AND resource.{$requestPathPropertyName} = :requestPath"
            . " AND resource.{$publishedPropertyName} = true"
            . " ORDER BY resource.{$siteCmsResourceIdPropertyName} ASC";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('siteCmsResource', $siteCmsResourceId);
        $dQuery->setParameter('requestPath', $requestPath);
        $dQuery->setMaxResults(1);

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
