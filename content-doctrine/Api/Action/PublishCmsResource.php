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
    protected $cmsResourceSyncToProperties = [];

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
     * @param array         $cmsResourceSyncToProperties
     * @param array         $contentVersionSyncToProperties
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourceHistory,
        string $entityClassContentVersion,
        string $classCmsResourceBasic,
        string $classContentVersionBasic,
        array $cmsResourceSyncToProperties = [],
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

        $this->cmsResourceSyncToProperties = $cmsResourceSyncToProperties;
        $this->contentVersionSyncToProperties = $contentVersionSyncToProperties;
    }

    /**
     * @todo use a Doctrine transaction
     *
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     *
     * @return CmsResource
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        $repositoryContentVersion = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        $requestedContentVersionId = $cmsResource->getContentVersion()->getId();

        $existingContentVersion = $repositoryContentVersion->find(
            $requestedContentVersionId
        );

        if (empty($existingContentVersion)) {
            // @todo We might create this instead of throwing
            throw new ContentVersionNotExists(
                'No content version exists for content version ID: ' . $requestedContentVersionId
            );
        }

        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var CmsResourceEntity $existingCmsResourceEntity */
        $existingCmsResourceEntity = $repositoryCmsResource->find(
            $cmsResource->getId()
        );

        $properties = $cmsResource->getProperties();

        if ($existingCmsResourceEntity) {
            return $this->update(
                $existingCmsResourceEntity,
                $properties,
                $publishedByUserId,
                $publishReason
            );
        }

        /** @var CmsResource::class $cmsResourceEntityClass */
        $cmsResourceEntityClass = $this->entityClassCmsResource;

        /** @var CmsResourceEntity $newCmsResourceEntity */
        $newCmsResourceEntity = new $cmsResourceEntityClass(
            $cmsResource->getId(),
            true,
            $existingContentVersion,
            $properties,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourceEntity);
        $this->entityManager->flush($newCmsResourceEntity);

        $newCmsResourceHistory = $this->buildHistory(
            $newCmsResourceEntity,
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
            $newCmsResourceEntity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }

    /**
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $publishedByUserId
     * @param string            $publishReason
     *
     * @return CmsResourceHistory
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
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
     * @param array             $properties
     * @param string            $publishedByUserId
     * @param string            $publishReason
     *
     * @return CmsResource
     */
    protected function update(
        CmsResourceEntity $existingCmsResource,
        array $properties,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        $existingCmsResource->setProperties(
            $properties
        );

        $this->entityManager->flush($existingCmsResource);

        $newCmsResourceHistory = $this->buildHistory(
            $existingCmsResource,
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
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
