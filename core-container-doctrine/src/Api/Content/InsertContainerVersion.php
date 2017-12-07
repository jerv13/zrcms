<?php

namespace Zrcms\CoreContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContainerVersion
    extends InsertContentVersion
    implements \Zrcms\CoreContainer\Api\Content\InsertContainerVersion
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
     * @param ContainerVersion|ContentVersion $containerVersion
     * @param array                           $options
     *
     * @return ContainerVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $containerVersion,
            $options
        );
    }
}
