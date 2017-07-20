<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentRevision implements \Zrcms\Content\Api\Repository\InsertContentRevision
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentRevisionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentRevisionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentRevisionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentRevisionClass = $contentRevisionClass;
    }

    /**
     * @param ContentRevision $contentRevision
     * @param array           $options
     *
     * @return ContentRevision
     */
    public function __invoke(
        ContentRevision $contentRevision,
        array $options = []
    ): ContentRevision
    {
        $contentRevision->assertIsNew();

        $this->entityManager->persist($contentRevision);
        $this->entityManager->flush($contentRevision);

        return $contentRevision;
    }
}
