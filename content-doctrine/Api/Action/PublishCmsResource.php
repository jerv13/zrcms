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
     * @param CmsResource $cmsResourceRequest
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
     *
     * @return CmsResource
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        CmsResource $cmsResourceRequest,
        string $publishedByUserId,
        string $publishReason,
        string $publishDate = null
    ): CmsResource {
        $contentEntity = $this->fetchContentEntity(
            $cmsResourceRequest
        );

        if (empty($contentEntity)) {
            $contentEntity = $this->newContentEntity($cmsResourceRequest);
        }

        $cmsResourceEntity = $this->fetchCmsResourceEntity(
            $cmsResourceRequest
        );

        if (empty($cmsResourceEntity)) {
            $cmsResourceEntity = $this->newCmsResourceEntity(
                $cmsResourceRequest,
                $contentEntity
            );
        }

        $cmsResourceEntity->update(
            true,
            $contentEntity,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );

        $this->entityManager->persist($cmsResourceEntity);
        $this->entityManager->flush($cmsResourceEntity);

        $newCmsResourceHistory = $this->buildHistory(
            $cmsResourceEntity,
            $cmsResourceRequest,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourceHistory);
        $this->entityManager->flush($newCmsResourceHistory);

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
     * @param CmsResource $cmsResourceRequest
     *
     * @return null|CmsResourceEntity
     */
    protected function fetchCmsResourceEntity(
        CmsResource $cmsResourceRequest
    ) {
        $cmsResourceId = $cmsResourceRequest->getId();

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
     * @param CmsResource   $cmsResourceRequest
     * @param ContentEntity $contentEntity
     *
     * @return CmsResourceEntity
     */
    protected function newCmsResourceEntity(
        CmsResource $cmsResourceRequest,
        ContentEntity $contentEntity
    ): CmsResourceEntity
    {
        $entityClass = $this->entityClassCmsResource;

        /** @var CmsResourceEntity $cmsResourceEntity */
        $cmsResourceEntity = new $entityClass(
            $cmsResourceRequest->getId(),
            $cmsResourceRequest,
            $contentEntity,
            $cmsResourceRequest->getCreatedByUserId(),
            $cmsResourceRequest->getCreatedReason(),
            $cmsResourceRequest->getCreatedDate()
        );

        $this->entityManager->persist($cmsResourceEntity);
        $this->entityManager->flush($cmsResourceEntity);

        return $cmsResourceEntity;
    }

    /**
     * @param CmsResource $cmsResourceRequest
     *
     * @return null|ContentEntity
     */
    protected function fetchContentEntity(
        CmsResource $cmsResourceRequest
    ) {
        $contentVersionId = $cmsResourceRequest->getContentVersionId();

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
     * @param CmsResource $cmsResourceRequest
     *
     * @return ContentEntity
     */
    protected function newContentEntity(
        CmsResource $cmsResourceRequest
    ): ContentEntity
    {
        $contentVersion = $cmsResourceRequest->getContentVersion();

        $entityClass = $this->entityClassContentVersion;

        /** @var ContentEntity $contentEntity */
        $contentEntity = new $entityClass(
            $contentVersion->getId(),
            $contentVersion->getProperties(),
            $contentVersion->getCreatedByUserId(),
            $contentVersion->getCreatedReason(),
            $contentVersion->getCreatedDate()
        );

        $this->entityManager->persist($contentEntity);
        $this->entityManager->flush($contentEntity);

        return $contentEntity;
    }

    /**
     * @param CmsResourceEntity $cmsResourceEntity
     * @param CmsResource       $cmsResourceRequest
     * @param string            $publishedByUserId
     * @param string            $publishReason
     *
     * @return CmsResourceHistory
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
        CmsResource $cmsResourceRequest,
        string $publishedByUserId,
        string $publishReason
    ) {
        /** @var CmsResourceHistoryEntity::class $cmsResourceHistoryEntityClass */
        $cmsResourceHistoryEntityClass = $this->entityClassCmsResourceHistory;

        /** @var CmsResourceHistory $newCmsResourceHistory */
        return new $cmsResourceHistoryEntityClass(
            null,
            Action::PUBLISH_CMS_RESOURCE,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason
        );
    }

    /**
     * @param CmsResourceEntity $existingCmsResource
     * @param CmsResource       $cmsResourceRequest
     * @param string            $publishedByUserId
     * @param string            $publishReason
     *
     * @return CmsResource
     */
    protected function update(
        CmsResourceEntity $existingCmsResource,
        CmsResource $cmsResourceRequest,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        $existingCmsResource->update(
            $cmsResourceRequest->isPublished(),
            $this->entityClassContentVersion
        );

        $this->entityManager->flush($existingCmsResource);

        $newCmsResourceHistory = $this->buildHistory(
            $existingCmsResource,
            $cmsResourceRequest,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourceHistory);
        $this->entityManager->flush($newCmsResourceHistory);

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $existingCmsResource,
            $this->contentVersionSyncToProperties
        );
    }
}
