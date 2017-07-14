<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertContent implements \Zrcms\Content\Api\Repository\UpsertContent
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
     * @param Content $content
     * @param array   $options
     *
     * @return Content
     */
    public function __invoke(
        Content $content,
        array $options = []
    ): Content
    {
        $contentClass = $this->contentClass;
        $repository = $this->entityManager->getRepository(
            $contentClass
        );

        $contentExisting = $repository->find($content->getId());

        if (empty($contentExisting)) {
            // create
            $this->entityManager->persist($content);
            $this->entityManager->flush($content);
            return $content;
        }

        $contentNew = new $contentClass(
            $content->getProperties(),
            $content->getCreatedByUserId(),
            $content->getCreatedReason()
        );

        $this->entityManager->persist($contentNew);
        $this->entityManager->flush($contentNew);

        return $contentNew;
    }
}
