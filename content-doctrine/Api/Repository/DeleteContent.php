<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeleteContent implements \Zrcms\Content\Api\Repository\DeleteContent
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentClass = $contentClass;
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
            $this->contentClass
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
