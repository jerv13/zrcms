<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\ActionCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstract;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @todo   Use transactions here as versions can be saved even if the resource fails
 *
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertCmsResource extends ApiAbstract implements \Zrcms\Core\Api\CmsResource\UpsertCmsResource
{
    protected $entityManager;
    protected $entityClassCmsResource;
    protected $entityClassCmsResourceHistory;
    protected $entityClassContentVersion;
    protected $classCmsResourceBasic;
    protected $classContentVersionBasic;
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassCmsResourceHistory
     * @param string        $entityClassContentVersion
     * @param string        $classCmsResourceBasic
     * @param string        $classContentVersionBasic
     * @param array         $contentVersionSyncToProperties
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourceHistory,
        string $entityClassContentVersion,
        string $classCmsResourceBasic,
        string $classContentVersionBasic,
        array $contentVersionSyncToProperties = []
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
        $this->classCmsResourceBasic = $classCmsResourceBasic;
        $this->classContentVersionBasic = $classContentVersionBasic;

        $this->contentVersionSyncToProperties = $contentVersionSyncToProperties;
    }

    /**
     * @param CmsResource $cmsResource
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param null        $modifiedDate
     *
     * @return CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource {
        $isNewContent = false;
        $contentEntity = $this->fetchContentEntity(
            $cmsResource
        );

        if (empty($contentEntity)) {
            $contentEntity = $this->newContentEntity($cmsResource);
            $this->entityManager->persist($contentEntity);
            $this->entityManager->flush($contentEntity);
            $isNewContent = true;
        }

        $cmsResourceEntity = $this->fetchCmsResourceEntity(
            $cmsResource
        );

        if (empty($cmsResourceEntity)) {
            $cmsResourceEntity = $this->newCmsResourceEntity(
                $cmsResource,
                $contentEntity
            );
            $this->entityManager->persist($cmsResourceEntity);
        }

        $publishedStateChanged = ($cmsResource->isPublished() !== $cmsResourceEntity->isPublished());

        if ($isNewContent) {
            $cmsResourceEntity->setContentVersion(
                $contentEntity,
                $modifiedByUserId,
                $modifiedReason,
                $modifiedDate
            );
        }

        if ($publishedStateChanged) {
            $cmsResourceEntity->setPublished(
                $cmsResource->isPublished(),
                $modifiedByUserId,
                $modifiedReason,
                $modifiedDate
            );
        }

        $this->entityManager->flush($cmsResourceEntity);

        $action = ActionCmsResource::invoke(
            $cmsResource->isPublished(),
            $isNewContent
        );

        $cmsResourceHistoryEntity = $this->buildHistory(
            $cmsResourceEntity,
            $action,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
        $this->entityManager->persist($cmsResourceHistoryEntity);
        $this->entityManager->flush($cmsResourceHistoryEntity);

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $cmsResourceEntity,
            $this->contentVersionSyncToProperties
        );
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return null|object|CmsResourceEntity
     * @throws CmsResourceNotExists
     */
    protected function fetchCmsResourceEntity(
        CmsResource $cmsResource
    ) {
        $cmsResourceId = $cmsResource->getId();

        if (empty($cmsResourceId)) {
            return null;
        }

        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $cmsResourceEntity = $repository->find(
            $cmsResourceId
        );

        if (empty($cmsResourceEntity)) {
            return null;
            throw new CmsResourceNotExists(
                'CmsResource not found with ID: (' . $cmsResourceId . ')'
            );
        }

        return $cmsResourceEntity;
    }

    /**
     * @param CmsResource   $cmsResource
     * @param ContentEntity $contentEntity
     *
     * @return CmsResourceEntity
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    protected function newCmsResourceEntity(
        CmsResource $cmsResource,
        ContentEntity $contentEntity
    ): CmsResourceEntity {
        $entityClass = $this->entityClassCmsResource;

        /** @var CmsResourceEntity $cmsResourceEntity */
        $cmsResourceEntity = new $entityClass(
            $cmsResource->getId(),
            true,
            $contentEntity,
            $cmsResource->getCreatedByUserId(),
            $cmsResource->getCreatedReason(),
            $cmsResource->getCreatedDate()
        );

        return $cmsResourceEntity;
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return null|object|ContentEntity
     * @throws ContentVersionNotExists
     */
    protected function fetchContentEntity(
        CmsResource $cmsResource
    ) {
        $contentVersionId = $cmsResource->getContentVersionId();

        if (empty($contentVersionId)) {
            return null;
        }

        $repository = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        $existingContentVersion = $repository->find(
            $contentVersionId
        );

        if (empty($existingContentVersion)) {
            return null;
            throw new ContentVersionNotExists(
                'Content Version not found with ID: (' . $contentVersionId . ')'
            );
        }

        return $existingContentVersion;
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return ContentEntity
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    protected function newContentEntity(
        CmsResource $cmsResource
    ): ContentEntity {
        $contentVersion = $cmsResource->getContentVersion();

        $entityClass = $this->entityClassContentVersion;

        /** @var ContentEntity $contentEntity */
        $contentEntity = new $entityClass(
            $contentVersion->getId(),
            $contentVersion->getProperties(),
            $contentVersion->getCreatedByUserId(),
            $contentVersion->getCreatedReason(),
            $contentVersion->getCreatedDate()
        );

        return $contentEntity;
    }

    /**
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $action
     * @param string            $modifiedByUserId
     * @param string            $modifiedReason
     * @param null              $modifiedDate
     *
     * @return CmsResourceHistoryEntity
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
        string $action,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResourceHistoryEntity {
        /** @var CmsResourceHistoryEntity::class $cmsResourceHistoryEntityClass */
        $cmsResourceHistoryEntityClass = $this->entityClassCmsResourceHistory;

        return new $cmsResourceHistoryEntityClass(
            null,
            $action,
            $cmsResourceEntity,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }
}
