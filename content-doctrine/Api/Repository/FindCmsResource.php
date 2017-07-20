<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource implements \Zrcms\Content\Api\Repository\FindCmsResource
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
     * @param string $id
     * @param array  $options
     *
     * @return CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->cmsResourceClass
        );

        return $repository->find($id);
    }
}
