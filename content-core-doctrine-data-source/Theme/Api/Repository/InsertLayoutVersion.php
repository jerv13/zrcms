<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertLayoutVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion
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
     * @param LayoutVersion|ContentVersion $layoutVersion
     * @param array                           $options
     *
     * @return LayoutVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $layoutVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $layoutVersion,
            $options
        );
    }
}
