<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return LayoutVersionBasic|ContentVersion|null
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
