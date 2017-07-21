<?php

namespace Zrcms\ContentDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstractContentVersion extends ApiAbstract
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClass
    ) {
        $this->assertValidEntityClass(
            $entityClass,
            ContentVersion::class
        );

        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }
}
