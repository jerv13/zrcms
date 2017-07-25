<?php

namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Action;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentDoctrine\Api\ApiAbstract;

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
    protected $entityClassCmsResourcePublishHistory;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $entityClassCmsResourcePublishHistory
     * @param string        $entityClassContentVersion
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $entityClassCmsResourcePublishHistory,
        string $entityClassContentVersion
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
    }

    /**
     * @todo use a Doctrine transaction
     *
     * @param CmsResource $cmsResource
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $existingCmsResource = $repositoryCmsResource->find(
            $cmsResource->getId()
        );

        if (empty($existingCmsResource)) {
            return false;
        }

        /** @var CmsResourcePublishHistory::class $cmsResourcePublishHistoryClass */
        $cmsResourcePublishHistoryClass = $this->entityClassCmsResourcePublishHistory;

        $historyProperties = $cmsResource->getProperties();
        $historyProperties[PropertiesCmsResourcePublishHistory::ACTION] = Action::PUBLISH_CMS_RESOURCE;

        $newCmsResourcePublishHistory = new $cmsResourcePublishHistoryClass(
            $historyProperties,
            $unpublishedByUserId,
            $unpublishReason
        );

        $this->entityManager->remove($existingCmsResource);
        $this->entityManager->persist($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResourcePublishHistory);
        $this->entityManager->flush($existingCmsResource);

        return true;
    }
}
