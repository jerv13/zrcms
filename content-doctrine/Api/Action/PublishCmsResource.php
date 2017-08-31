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
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassCmsResourcePublishHistory
     * @param string        $entityClassContentVersion
     * @param string        $classCmsResourceBasic
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourcePublishHistory,
        string $entityClassContentVersion,
        string $classCmsResourceBasic
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

        $existingContentVersion = $repositoryContentVersion->find(
            $cmsResource->getContentVersionId()
        );

        if (empty($existingContentVersion)) {
            throw new ContentVersionNotExistsException(
                'No content version exists for content version ID: ' . $cmsResource->getContentVersionId()
            );
        }

        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        /** @var CmsResourceEntity $existingCmsResource */
        $existingCmsResource = $repositoryCmsResource->find(
            $cmsResource->getId()
        );

        $properties = $cmsResource->getProperties();

        $properties[PropertiesCmsResource::PUBLISHED] = true;

        if ($existingCmsResource) {
            return $this->update(
                $existingCmsResource,
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
            $publishReason,
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
            $newCmsResourceEntity
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
            $existingCmsResource
        );
    }
}
