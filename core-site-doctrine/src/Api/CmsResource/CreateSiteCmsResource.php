<?php

namespace Zrcms\CoreSiteDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\CreateCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceHistoryEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateSiteCmsResource extends CreateCmsResource implements \Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteCmsResourceEntity::class,
            SiteCmsResourceHistoryEntity::class,
            SiteVersionEntity::class,
            SiteCmsResourceBasic::class,
            SiteVersionBasic::class,
            []
        );
    }

    /**
     * @param null|string $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param null|string $modifiedDate
     *
     * @return SiteCmsResource|CmsResource
     * @throws CmsResourceExists
     * @throws ContentVersionNotExists
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function __invoke(
        $id,
        bool $published,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource {
        return parent::__invoke(
            $id,
            $published,
            $contentVersionId,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }
}
