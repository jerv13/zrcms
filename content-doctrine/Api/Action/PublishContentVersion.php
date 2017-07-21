<?php
namespace Zrcms\ContentDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Api\ApiAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishContentVersion
    extends ApiAbstract
    implements \Zrcms\Content\Api\Action\PublishContentVersion
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





        // @todo use a Doctrine transaction
        $repositoryCmsResource = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $existingCmsResource = $repositoryCmsResource->find(
            $cmsResource->getId()
        );

        if ($existingCmsResource) {
            $this->entityManager->remove($existingCmsResource);
        }

        $this->entityManager->persist($cmsResource);

        $this->entityManager->flush($existingCmsResource);
        $this->entityManager->flush($cmsResource);

        return $cmsResource;
    }
}
