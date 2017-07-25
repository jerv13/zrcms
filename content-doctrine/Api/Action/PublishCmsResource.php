<?php
namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\Action;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;
use Zrcms\ContentDoctrine\Api\BasicContentVersionTrait;

/**
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
    protected $entityClass;

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
     * @param EntityManager           $entityManager
     * @param string                  $entityClassCmsResource
     * @param string                  $entityClassCmsResourcePublishHistory
     * @param string                  $entityClassContentVersion
     * @param string                  $classCmsResourceBasic
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
        $this->entityClass = $entityClassCmsResource;
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

        $newContentVersion = $repositoryContentVersion->find(
            $cmsResource->getContentVersionId()
        );

        if (empty($newContentVersion)) {
            throw new ContentVersionNotExistsException(
                'No content version exists for content version ID: ' . $cmsResource->getContentVersionId()
            );
        }

        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClass
        );

        /** @var CmsResource $existingCmsResource */
        $existingCmsResource = $repositoryCmsResource->find(
            $cmsResource->getId()
        );

        /** @var CmsResourcePublishHistory::class $cmsResourcePublishHistoryClass */
        $cmsResourcePublishHistoryClass = $this->entityClassCmsResourcePublishHistory;

        $historyProperties = $cmsResource->getProperties();
        $historyProperties[PropertiesCmsResourcePublishHistory::ACTION] = Action::PUBLISH_CMS_RESOURCE;

        /** @var CmsResourcePublishHistory $newCmsResourcePublishHistory */
        $newCmsResourcePublishHistory = new $cmsResourcePublishHistoryClass(
            $historyProperties,
            $cmsResource->getCreatedByUserId(),
            $cmsResource->getCreatedReason()
        );

        /** @var CmsResource::class $cmsResourceClass */
        $cmsResourceClass = $this->entityClass;

        /** @var CmsResource $newCmsResource */
        $newCmsResource = new $cmsResourceClass(
            $cmsResource->getProperties(),
            $cmsResource->getCreatedByUserId(),
            $cmsResource->getCreatedReason()
        );

        // @todo Update instead of delete and remake
        if ($existingCmsResource) {
            $this->entityManager->remove($existingCmsResource);
            $this->entityManager->flush($existingCmsResource);
        }

        $this->entityManager->persist($newCmsResource);
        $this->entityManager->persist($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResource);

        return $this->newBasic($newCmsResource);
    }
}
