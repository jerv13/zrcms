<?php

namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Action;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

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
     * @var string
     */
    protected $classCmsResourceBasic;

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
     * @param string $cmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $cmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
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
            return false;
        }

        $existingCmsResource->setPublished(false);

        $this->entityManager->flush($existingCmsResource);

        $newCmsResourcePublishHistory = $this->buildHistory(
            $existingCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );

        $this->entityManager->persist($newCmsResourcePublishHistory);
        $this->entityManager->flush($newCmsResourcePublishHistory);

        return true;
    }

    /**
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $unpublishedByUserId
     * @param string            $unpublishReason
     *
     * @return CmsResourcePublishHistory
     */
    protected function buildHistory(
        CmsResourceEntity $cmsResourceEntity,
        string $unpublishedByUserId,
        string $unpublishReason
    ) {
        /** @var CmsResourcePublishHistory::class $cmsResourcePublishHistoryClass */
        $cmsResourcePublishHistoryEntityClass = $this->entityClassCmsResourcePublishHistory;

        return new $cmsResourcePublishHistoryEntityClass(
            null,
            Action::UNPUBLISH_CMS_RESOURCE,
            $cmsResourceEntity,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
