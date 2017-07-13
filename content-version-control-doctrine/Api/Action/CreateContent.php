<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Model\Content;

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
     * @var string
     */
    protected $draftEntityClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentEntityClass
     * @param string        $historyEntityClass
     * @param string        $draftEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentEntityClass,
        string $historyEntityClass,
        string $draftEntityClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentEntityClass = $contentEntityClass;
        $this->historyEntityClass = $historyEntityClass;
        $this->draftEntityClass = $draftEntityClass;
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
            $content->getUri(),
            $content->getSourceUri(),
            Action::COPY_CONTENT_TO_DRAFT,
            $content->getProperties(),
            $modifiedByUserId,
            $modifiedReason
        );

        $this->entityManager->persist($history);
        $this->entityManager->flush($history);

        // make new from existing
        $draftEntityClass = $this->draftEntityClass;
        /** @var Draft $newDraft */
        $newDraft = new $draftEntityClass(
            $content->getUri(),
            $content->getSourceUri(),
            $content->getProperties(),
            $modifiedByUserId,
            $modifiedReason
        );

        $this->entityManager->persist($newDraft);
        $this->entityManager->flush($newDraft);

        return $newDraft;
    }
}
