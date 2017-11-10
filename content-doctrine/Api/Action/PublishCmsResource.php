<?php
namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Exception\ContentVersionNotExists;
use Zrcms\Content\Model\Action;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistory;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

/**
 * Publish a new or existing CmsResource with new properties
 *
 * @author James Jervis - https://github.com/jerv13
 */
class PublishCmsResource
    extends ApiAbstract
    implements \Zrcms\Content\Api\Action\PublishCmsResource
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
     * @todo use a Doctrine transaction
     *
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
     *
     * @return CmsResource
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource {
        $contentEntity = $this->fetchContentEntity(
            $cmsResource
        );

        if (empty($contentEntity)) {
            $contentEntity = $this->newContentEntity($cmsResource);
            $this->entityManager->persist($contentEntity);
            $this->entityManager->flush($contentEntity);
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

        $cmsResourceEntity->setContentVersion(
            $contentEntity,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );

        $cmsResourceEntity->setPublished(
            true,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );

        $this->entityManager->flush($cmsResourceEntity);

        $cmsResourceHistoryEntity = $this->buildHistory(
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason,
            $publishDate
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
     * @param string            $publishedByUserId
     * @param string            $publishReason
     * @param string|null            $publishDate
     *
     * @return CmsResourceHistoryEntity
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ):CmsResourceHistoryEntity {
        /** @var CmsResourceHistoryEntity::class $cmsResourceHistoryEntityClass */
        $cmsResourceHistoryEntityClass = $this->entityClassCmsResourceHistory;

        return new $cmsResourceHistoryEntityClass(
            null,
            Action::PUBLISH_CMS_RESOURCE,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );
    }
}
