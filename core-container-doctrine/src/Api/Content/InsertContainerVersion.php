<?php

namespace Zrcms\CoreContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion as CoreInsert;
use Zrcms\CoreContainer\Model\ContainerVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContainerVersion extends InsertContentVersion implements CoreInsert
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            ContainerVersionEntity::class,
            ContainerVersionBasic::class
        );
    }

    /**
     * @param ContentVersion $containerVersion
     * @param array          $options
     *
     * @return ContentVersion
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion {
        return parent::__invoke(
            $containerVersion,
            $options
        );
    }
}
