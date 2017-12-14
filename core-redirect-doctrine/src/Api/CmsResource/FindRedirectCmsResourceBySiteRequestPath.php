<?php

namespace Zrcms\CoreRedirectDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath as CoreFindBySiteRequestPath;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourceBySiteRequestPath implements CoreFindBySiteRequestPath
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
        $this->entityClassCmsResource = RedirectCmsResourceEntity::class;
        $this->classCmsResourceBasic = RedirectCmsResourceBasic::class;

        $this->entityClassContentVersion = RedirectVersionEntity::class;
        $this->classContentVersionBasic = RedirectVersionBasic::class;

        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $requestPath
     * @param bool   $published
     * @param array  $options
     *
     * @return null|CmsResource|RedirectCmsResource
     * @throws \Exception
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $requestPath,
        bool $published = true,
        array $options = []
    ) {
        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource FROM {$this->entityClassCmsResource} resource"
            . " WHERE (resource.siteCmsResourceId = :siteCmsResource"
            // NOTE: siteCmsResource is a string, so empty is equivalent to NULL
            . " OR resource.siteCmsResourceId = '')"
            . " AND resource.requestPath = :requestPath"
            . " AND resource.published = :published"
            . " ORDER BY resource.siteCmsResourceId ASC";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('siteCmsResource', $siteCmsResourceId);
        $dQuery->setParameter('requestPath', $requestPath);
        $dQuery->setParameter('published', $published);
        $dQuery->setMaxResults(1);

        $result = $dQuery->getResult();

        if (empty($result)) {
            return null;
        }

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $result[0],
            $this->contentVersionSyncToProperties
        );
    }
}
