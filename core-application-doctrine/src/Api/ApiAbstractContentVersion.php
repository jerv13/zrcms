<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

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
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var array
     */
    protected $contentVersionSyncToProperties;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassContentVersion
     * @param string        $classContentVersionBasic
     * @param array         $contentVersionSyncToProperties
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $contentVersionSyncToProperties = []
    ) {
        $this->assertValidEntityClass(
            $entityClassContentVersion,
            ContentEntity::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassContentVersion = $entityClassContentVersion;
        $this->classContentVersionBasic = $classContentVersionBasic;
        $this->contentVersionSyncToProperties = $contentVersionSyncToProperties;
    }
}
