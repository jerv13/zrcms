<?php
namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\Action;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * Publish a new or existing CmsResource with new properties
 *
 * @author James Jervis - https://github.com/jerv13
 */
class PublishCmsResource
    extends ApiAbstract
    implements \Zrcms\Content\Api\Action\PublishCmsResource
{
    use BasicCmsResourceTrait;

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
    protected $entityClassCmsResourcePublishHistory;

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
     * @param string        $entityClassCmsResourcePublishHistory
     * @param string        $entityClassContentVersion
     * @param string        $classCmsResourceBasic
     * @param string        $classContentVersionBasic
     * @param array         $cmsResourceSyncToProperties
     * @param array         $contentVersionSyncToProperties
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourcePublishHistory,
        string $entityClassContentVersion,
        string $classCmsResourceBasic,
        string $classContentVersionBasic,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResource,
            CmsResource::class
        );

        $this->assertValidEntityClass(
            $entityClassCmsResourcePublishHistory,
            CmsResourcePublishHistory::class
        );

        $this->assertValidEntityClass(
            $entityClassContentVersion,
            ContentVersion::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResourcePublishHistory = $entityClassCmsResourcePublishHistory;
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
     * @throws ContentVersionNotExistsException
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
            throw new ContentVersionNotExistsException(
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

        $properties[PropertiesCmsResource::CONTENT_VERSION] = $existingContentVersion;

        $properties[PropertiesCmsResource::PUBLISHED] = true;

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
            $properties,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourceEntity);
        $this->entityManager->flush($newCmsResourceEntity);

        $newCmsResourcePublishHistory = $this->buildHistory(
            $newCmsResourceEntity,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResourcePublishHistory);

        return $this->newBasicCmsResource(
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
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     *
     * @return CmsResourcePublishHistory
     */
    protected function buildHistory(
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason
    ) {
        $historyProperties = $cmsResource->getProperties();
        $historyProperties[PropertiesCmsResourcePublishHistory::CMS_RESOURCE_ID]
            = $cmsResource->getId();
        $historyProperties[PropertiesCmsResourcePublishHistory::ACTION]
            = Action::PUBLISH_CMS_RESOURCE;

        /** @var CmsResourcePublishHistory::class $cmsResourcePublishHistoryClass */
        $cmsResourcePublishHistoryClass = $this->entityClassCmsResourcePublishHistory;

        /** @var CmsResourcePublishHistory $newCmsResourcePublishHistory */
        return new $cmsResourcePublishHistoryClass(
            $historyProperties,
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
        $existingCmsResource->updateProperties(
            $properties
        );

        $this->entityManager->flush($existingCmsResource);

        $newCmsResourcePublishHistory = $this->buildHistory(
            $existingCmsResource,
            $publishedByUserId,
            $publishReason
        );

        $this->entityManager->persist($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResourcePublishHistory);

        return $this->newBasicCmsResource(
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
