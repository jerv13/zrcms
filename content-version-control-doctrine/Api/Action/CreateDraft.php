<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Model\Action;
use Zrcms\ContentVersionControl\Model\Draft;
use Zrcms\ContentVersionControl\Model\History;
use Zrcms\ContentVersionControl\Model\Uri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CreateDraft implements \Zrcms\ContentVersionControl\Api\Action\CreateDraft
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
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return Draft
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): Draft
    {
        // make history entry
        $historyEntityClass = $this->historyEntityClass;
        /** @var History $history */
        $history = new $historyEntityClass(
            $uri,
            Uri::SOURCE_ON_CREATE,
            Action::CREATE_DRAFT,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->entityManager->persist($history);
        $this->entityManager->flush($history);

        // make new from existing
        $draftEntityClass = $this->draftEntityClass;
        /** @var Draft $newDraft */
        $newDraft = new $draftEntityClass(
            $uri,
            Uri::SOURCE_ON_CREATE,
            Action::CREATE_CONTENT,
            $createdByUserId,
            $createdReason
        );

        // @todo transaction here
        $this->entityManager->persist($newDraft);
        $this->entityManager->persist($history);
        $this->entityManager->flush($history);
        $this->entityManager->flush($newDraft);

        return $newDraft;
    }
}
