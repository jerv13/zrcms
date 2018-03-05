<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\ActionCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstract;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @todo   Use transactions here
 *
 * @author James Jervis - https://github.com/jerv13
 */
class CreateCmsResource extends ApiAbstract implements \Zrcms\Core\Api\CmsResource\CreateCmsResource
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
     * @param null|string $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param null|string $modifiedDate
     *
     * @return CmsResource
     * @throws CmsResourceExists
     * @throws ContentVersionNotExists
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function __invoke(
        $id,
        bool $published,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource {
        $contentEntity = $this->fetchContentEntity(
            $contentVersionId
        );

        if (empty($id)) {
            $id = GetGuidV4::invoke();
        }

        $this->assertValidCmsResourceId(
            $id
        );

        $cmsResourceEntity = $this->newCmsResourceEntity(
            $id,
            $published,
            $contentEntity,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        $this->entityManager->persist($cmsResourceEntity);
        $this->entityManager->flush($cmsResourceEntity);

        $action = ActionCmsResource::invoke(
            $cmsResourceEntity->isPublished(),
            true
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
     * @param $cmsResourceId
     *
     * @return null|object
     * @throws CmsResourceExists
     */
    protected function assertValidCmsResourceId(
        $cmsResourceId
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $cmsResourceEntity = $repository->find(
            $cmsResourceId
        );

        if (!empty($cmsResourceEntity)) {
            throw new CmsResourceExists(
                'CmsResource already exists with ID: (' . $cmsResourceId . ')'
            );
        }

        return $cmsResourceEntity;
    }

    /**
     * @param               $id
     * @param bool          $published
     * @param ContentEntity $contentEntity
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param null          $modifiedDate
     *
     * @return CmsResourceEntity
     */
    protected function newCmsResourceEntity(
        $id,
        bool $published,
        ContentEntity $contentEntity,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResourceEntity {
        $entityClass = $this->entityClassCmsResource;

        /** @var CmsResourceEntity $cmsResourceEntity */
        $cmsResourceEntity = new $entityClass(
            $id,
            $published,
            $contentEntity,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );

        return $cmsResourceEntity;
    }

    /**
     * @param string $contentVersionId
     *
     * @return ContentEntity
     * @throws ContentVersionNotExists
     */
    protected function fetchContentEntity(
        string $contentVersionId
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassContentVersion
        );

        /** @var ContentEntity $existingContentVersion */
        $existingContentVersion = $repository->find(
            $contentVersionId
        );

        if (empty($existingContentVersion)) {
            throw new ContentVersionNotExists(
                'Content Version not found with ID: (' . $contentVersionId . ')'
            );
        }

        return $existingContentVersion;
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
