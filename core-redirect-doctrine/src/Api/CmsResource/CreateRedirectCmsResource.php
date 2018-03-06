<?php

namespace Zrcms\CoreRedirectDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\CreateCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource as CoreCreate;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateRedirectCmsResource extends CreateCmsResource implements CoreCreate
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
            RedirectCmsResourceEntity::class,
            RedirectCmsResourceHistoryEntity::class,
            RedirectVersionEntity::class,
            RedirectCmsResourceBasic::class,
            RedirectVersionBasic::class,
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
     * @return RedirectCmsResource|CmsResource
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
