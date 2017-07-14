<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Model\Action;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;
use Zrcms\ContentVersionControl\Model\History;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CopyContentToDraft implements \Zrcms\ContentVersionControl\Api\Action\CopyContentToDraft
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

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
     * @param string        $historyEntityClass
     * @param string        $draftEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $historyEntityClass,
        string $draftEntityClass
    ) {
        $this->entityManager = $entityManager;
        $this->historyEntityClass = $historyEntityClass;
        $this->draftEntityClass = $draftEntityClass;
    }


    /**
     * @param Content  $content
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param array  $options
     *
     * @return Draft
     */
    public function __invoke(
        Content $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Draft
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

        // @todo transaction here
        $this->entityManager->persist($newDraft);
        $this->entityManager->persist($history);
        $this->entityManager->flush($history);
        $this->entityManager->flush($newDraft);

        return $newDraft;
    }
}
