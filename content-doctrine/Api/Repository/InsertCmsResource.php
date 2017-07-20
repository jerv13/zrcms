<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertCmsResource implements \Zrcms\Content\Api\Repository\InsertCmsResource
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentVersionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentVersionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentVersionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentVersionClass = $contentVersionClass;
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
        $cmsResource->assertIsNew();

        $this->entityManager->persist($cmsResource);
        $this->entityManager->flush($cmsResource);

        return $cmsResource;
    }
}
