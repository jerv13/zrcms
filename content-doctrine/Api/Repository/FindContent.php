<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContent implements \Zrcms\Content\Api\Repository\FindContent
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
     * @return Content|null
     */
    public function __invoke(
        string $id,
        array $options = []
    )
    {
        $repository = $this->entityManager->getRepository(
            $this->contentClass
        );

        return $repository->find($id);
    }
}
