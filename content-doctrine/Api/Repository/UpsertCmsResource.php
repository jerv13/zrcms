<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertCmsResource implements \Zrcms\Content\Api\Repository\UpsertCmsResource
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $cmsResourceClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $cmsResourceClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $cmsResourceClass
    ) {
        $this->entityManager = $entityManager;
        $this->cmsResourceClass = $cmsResourceClass;
    }

    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): CmsResource
    {
        $cmsResourceClass = $this->cmsResourceClass;
        $repository = $this->entityManager->getRepository(
            $cmsResourceClass
        );

        $cmsResourceExisting = $repository->find($cmsResource->getUri());

        if (empty($cmsResourceExisting)) {
            // create
            $this->entityManager->persist($cmsResource);
            $this->entityManager->flush($cmsResource);
            return $cmsResource;
        }

        $cmsResourceNew = new $cmsResourceClass(
            $cmsResource->getUri(),
            $cmsResource->getSource(),
            $cmsResource->getContent(),
            $cmsResource->getCreatedByUserId(),
            $cmsResource->getCreatedReason()
        );

        $this->entityManager->persist($cmsResourceNew);
        $this->entityManager->flush($cmsResourceNew);

        return $cmsResourceNew;
    }
}
