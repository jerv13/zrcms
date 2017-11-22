<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageVersion;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertPageVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCore\Page\Api\Content\InsertPageVersion
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
     * @return PageVersion|ContentVersion
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
