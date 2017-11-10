<?php

namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Action;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishCmsResource
    extends ApiAbstract
    implements \Zrcms\Content\Api\Action\UnpublishCmsResource
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
     * @var string
     */
    protected $entityClassCmsResourceHistory;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassCmsResourceHistory
     * @param string        $entityClassContentVersion
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourceHistory,
        string $entityClassContentVersion
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResource,
            CmsResourceEntity::class
        );

        $this->assertValidEntityClass(
            $entityClassCmsResourceHistory,
            CmsResourceHistoryEntity::class
        );

        $this->assertValidEntityClass(
            $entityClassContentVersion,
            ContentEntity::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResourceHistory = $entityClassCmsResourceHistory;
        $this->entityClassCmsResource = $entityClassCmsResource;
        $this->entityClassContentVersion = $entityClassContentVersion;
    }

    /**
     * @todo use a Doctrine transaction
     *
     * @param string      $cmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $cmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool
    {
        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var CmsResourceEntity $existingCmsResource */
        $existingCmsResource = $repositoryCmsResource->find(
            $cmsResourceId
        );

        if (empty($existingCmsResource)) {
            // no existing, can not unpublish
            return false;
        }

        $existingCmsResource->setPublished(
            false,
            $unpublishedByUserId,
            $unpublishReason,
            $unpublishDate
        );

        $this->entityManager->flush($existingCmsResource);

        $newCmsResourceHistory = $this->buildHistory(
            $existingCmsResource,
            $unpublishedByUserId,
            $unpublishReason,
            $unpublishDate
        );

        $this->entityManager->persist($newCmsResourceHistory);
        $this->entityManager->flush($newCmsResourceHistory);

        return true;
    }

    /**
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $unpublishedByUserId
     * @param string            $unpublishReason
     * @param string|null       $unpublishDate
     *
     * @return CmsResourceHistoryEntity
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ):CmsResourceHistoryEntity {
        /** @var CmsResourceHistoryEntity::class $cmsResourceHistoryClass */
        $cmsResourceHistoryEntityClass = $this->entityClassCmsResourceHistory;

        return new $cmsResourceHistoryEntityClass(
            null,
            Action::UNPUBLISH_CMS_RESOURCE,
            $cmsResourceEntity,
            $unpublishedByUserId,
            $unpublishReason,
            $unpublishDate
        );
    }
}
