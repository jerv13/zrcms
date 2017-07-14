<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Exception\ContentAlreadyExistsException;
use Zrcms\ContentVersionControl\Model\Action;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;
use Zrcms\ContentVersionControl\Model\History;
use Zrcms\ContentVersionControl\Model\Uri;
use Zrcms\ContentVersionControlDoctrine\Api\Repository\FindContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PublishDraft implements \Zrcms\ContentVersionControl\Api\Action\PublishDraft
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FindContent
     */
    protected $findContent;

    /**
     * @var string
     */
    protected $historyEntityClass;

    /**
     * @var string
     */
    protected $draftEntityClass;

    /**
     * @var string
     */
    protected $contentEntityClass;

    /**
     * @param EntityManager $entityManager
     * @param FindContent   $findContent
     * @param string        $historyEntityClass
     * @param string        $draftEntityClass
     * @param string        $contentEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        FindContent $findContent,
        string $historyEntityClass,
        string $draftEntityClass,
        string $contentEntityClass
    ) {
        $this->entityManager = $entityManager;
        $this->findContent = $findContent;
        $this->historyEntityClass = $historyEntityClass;
        $this->draftEntityClass = $draftEntityClass;
        $this->contentEntityClass = $contentEntityClass;
    }

    /**
     * @param Draft  $content
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     * @param array  $options
     *
     * @return Content
     * @throws ContentAlreadyExistsException
     */
    public function __invoke(
        Draft $draft,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Content
    {
        $uri = $draft->getUri();
        $existingContent = $this->findContent->__invoke(
            $uri
        );

        if (!empty($existingContent)) {
            throw new ContentAlreadyExistsException(
                "Content for URI {$uri} already exist: " . get_class($existingContent)
            );
        }

        // make history entry
        $historyEntityClass = $this->historyEntityClass;
        /** @var History $history */
        $history = new $historyEntityClass(
            $draft->getUri(),
            $draft->getUri(),
            Action::PUBLISH_DRAFT,
            $draft->getProperties(),
            $modifiedByUserId,
            $modifiedReason
        );

        // make new from existing
        $contentEntityClass = $this->contentEntityClass;
        /** @var Content $newContent */
        $newContent = new $contentEntityClass(
            $uri,
            $uri,
            Action::CREATE_CONTENT,
            $modifiedByUserId,
            $modifiedReason
        );

        // @todo transaction here
        $this->entityManager->persist($newContent);
        $this->entityManager->persist($history);
        $this->entityManager->flush($history);
        $this->entityManager->flush($newContent);

        return $newContent;
    }
}
