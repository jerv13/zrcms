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
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassContentVersion
     * @param string        $classContentVersionBasic
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassContentVersion,
        string $classContentVersionBasic
    ) {
        $this->assertValidEntityClass(
            $entityClassContentVersion,
            ContentVersion::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassContentVersion = $entityClassContentVersion;
        $this->classContentVersionBasic = $classContentVersionBasic;
    }
}
