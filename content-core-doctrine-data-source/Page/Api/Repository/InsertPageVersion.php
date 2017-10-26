<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageVersion;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertPageVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCore\Page\Api\Repository\InsertPageVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageVersionEntity::class,
            PageVersionBasic::class
        );
    }

    /**
     * @param PageVersion|ContentVersion $pageVersion
     * @param array                      $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $pageVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $pageVersion,
            $options
        );
    }
}
