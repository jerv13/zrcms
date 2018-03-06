<?php

namespace Zrcms\CoreThemeDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\CreateCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\CreateLayoutCmsResource as CoreCreate;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateLayoutCmsResource extends CreateCmsResource implements CoreCreate
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
            LayoutCmsResourceEntity::class,
            LayoutCmsResourceHistoryEntity::class,
            LayoutVersionEntity::class,
            LayoutCmsResourceBasic::class,
            LayoutVersionBasic::class,
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
     * @return LayoutCmsResource|CmsResource
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
