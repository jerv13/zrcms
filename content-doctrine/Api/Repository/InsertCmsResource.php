<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\ContentRevision;

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
    protected $contentRevisionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentRevisionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentRevisionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentRevisionClass = $contentRevisionClass;
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
