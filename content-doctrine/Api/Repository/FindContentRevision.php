<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentRevision implements \Zrcms\Content\Api\Repository\FindContentRevision
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
     * @param string $id
     * @param array  $options
     *
     * @return Content|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->contentRevisionClass
        );

        return $repository->find($id);
    }
}
