<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion implements \Zrcms\Content\Api\Repository\FindContentVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->contentVersionClass
        );

        return $repository->find($id);
    }
}
