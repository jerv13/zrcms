<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ActionCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstract;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertCmsResource extends ApiAbstract implements \Zrcms\Core\Api\CmsResource\UpsertCmsResource
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
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var array
     */
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassCmsResourceHistory
     * @param string        $entityClassContentVersion
     * @param string        $classCmsResourceBasic
     * @param string        $classContentVersionBasic
     * @param array         $contentVersionSyncToProperties
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
     * @param string|null $modifiedDate
     *
     * @return CmsResource
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
     * @return null|CmsResourceEntity
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
        }

        return $cmsResourceEntity;
    }

    /**
     * @param CmsResource   $cmsResource
     * @param ContentEntity $contentEntity
     *
     * @return CmsResourceEntity
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
     * @return null|ContentEntity
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
        }

        return $existingContentVersion;
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return ContentEntity
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
    ):CmsResourceHistoryEntity {
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
