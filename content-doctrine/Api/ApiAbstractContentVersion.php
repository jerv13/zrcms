<?php

namespace Zrcms\ContentDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstractContentVersion extends ApiAbstract
{
    use BasicContentVersionTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClass
     * @param string        $classContentVersionBasic
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClass,
        string $classContentVersionBasic
    ) {
        $this->assertValidEntityClass(
            $entityClass,
            ContentVersion::class
        );

        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->classContentVersionBasic = $classContentVersionBasic;
    }
}
