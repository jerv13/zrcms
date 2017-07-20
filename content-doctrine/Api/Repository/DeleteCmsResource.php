<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteCmsResource implements \Zrcms\Content\Api\Repository\DeleteCmsResource
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
     * @return bool success
     */
    public function __invoke(
        string $id,
        array $options = []
    ): bool
    {
        $repository = $this->entityManager->getRepository(
            $this->cmsResourceClass
        );

        $cmsResource = $repository->find($id);

        if (empty($cmsResource)) {
            return false;
        }

        $this->entityManager->remove($cmsResource);
        $this->entityManager->flush($cmsResource);

        return true;
    }
}
