<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Block\Entity\BlockVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            BlockVersionEntity::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return BlockVersionBasic|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        throw new \Exception('not implemented');
        parent::__invoke(
            $id,
            $options
        );
    }
}
