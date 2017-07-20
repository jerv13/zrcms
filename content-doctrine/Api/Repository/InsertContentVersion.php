<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion implements \Zrcms\Content\Api\Repository\InsertContentVersion
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentVersionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentVersionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentVersionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentVersionClass = $contentVersionClass;
    }

    /**
     * @param ContentVersion $contentVersion
     * @param array           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): ContentVersion
    {
        $contentVersion->assertIsNew();

        $this->entityManager->persist($contentVersion);
        $this->entityManager->flush($contentVersion);

        return $contentVersion;
    }
}
