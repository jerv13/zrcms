<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\CreateCmsResource;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource as CoreCreate;
use Zrcms\CorePage\Model\PageTemplateCmsResource;
use Zrcms\CorePage\Model\PageTemplateCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageTemplateCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageTemplateCmsResourceHistoryEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePageTemplateCmsResource extends CreateCmsResource implements CoreCreate
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
            PageTemplateCmsResourceEntity::class,
            PageTemplateCmsResourceHistoryEntity::class,
            PageVersionEntity::class,
            PageTemplateCmsResourceBasic::class,
            PageVersionBasic::class,
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
     * @return PageTemplateCmsResource|CmsResource
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
