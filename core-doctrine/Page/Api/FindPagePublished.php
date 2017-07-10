<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPagePublished implements \Zrcms\Core\Page\Api\FindPagePublished
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return PagePublished|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            \Zrcms\CoreDoctrine\Page\Entity\PagePublished::class
        );

        return $repository->find($uri);
    }
}
