<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\ContentVersionControl\Model\Draft;

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
     * @param string        $historyEntityClass
     * @param string        $draftEntityClass
     * @param string        $contentEntityClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $historyEntityClass,
        string $draftEntityClass,
        string $contentEntityClass
    ) {
        $this->entityManager = $entityManager;
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
     */
    public function __invoke(
        Draft $content,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): Content
    {

    }
}
