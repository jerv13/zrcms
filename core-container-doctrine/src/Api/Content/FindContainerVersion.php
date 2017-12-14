<?php

namespace Zrcms\CoreContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerVersion extends FindContentVersion implements \Zrcms\CoreContainer\Api\Content\FindContainerVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return ContainerVersionBasic|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        return parent::__invoke(
            $id,
            $options
        );
    }
}
