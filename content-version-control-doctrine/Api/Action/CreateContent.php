<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Model\Action;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;
use Zrcms\ContentVersionControl\Model\History;
use Zrcms\ContentVersionControl\Model\Uri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CreateContent implements \Zrcms\ContentVersionControl\Api\Action\CreateContent
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentEntityClass;

    /**
     * @var string
     */
    protected $historyEntityClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentEntityClass
     * @param string        $historyEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentEntityClass,
        string $historyEntityClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentEntityClass = $contentEntityClass;
        $this->historyEntityClass = $historyEntityClass;
    }

    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return Content
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): Content
    {
        // make history entry
        $historyEntityClass = $this->historyEntityClass;
        /** @var History $history */
        $history = new $historyEntityClass(
            $uri,
            Uri::SOURCE_ON_CREATE,
            Action::CREATE_CONTENT,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->entityManager->persist($history);
        $this->entityManager->flush($history);

        // make new from existing
        $contentEntityClass = $this->contentEntityClass;
        /** @var Content $newContent */
        $newContent = new $contentEntityClass(
            $uri,
            Uri::SOURCE_ON_CREATE,
            Action::CREATE_CONTENT,
            $createdByUserId,
            $createdReason
        );

        // @todo transaction here
        $this->entityManager->persist($newContent);
        $this->entityManager->persist($history);
        $this->entityManager->flush($history);
        $this->entityManager->flush($newContent);

        return $newContent;
    }
}
