<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Exception\ContentAlreadyExistsException;
use Zrcms\ContentVersionControl\Model\Action;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\History;
use Zrcms\ContentVersionControl\Model\Uri;
use Zrcms\ContentVersionControlDoctrine\Api\Repository\FindContent;

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
     * @var FindContent
     */
    protected $findContent;

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
     * @param FindContent   $findContent
     * @param string        $contentEntityClass
     * @param string        $historyEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        FindContent $findContent,
        string $contentEntityClass,
        string $historyEntityClass
    ) {
        $this->entityManager = $entityManager;
        $this->findContent = $findContent;
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
     * @throws ContentAlreadyExistsException
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): Content
    {
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
            $uri,
            Uri::SOURCE_ON_CREATE,
            Action::CREATE_CONTENT,
            $properties,
            $createdByUserId,
            $createdReason
        );

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
