<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertPageContainerVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageContainerVersionEntity::class,
            PageContainerVersionBasic::class
        );
    }

    /**
     * @param PageContainerVersion|ContentVersion $pageContainerVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $pageContainerVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $pageContainerVersion,
            $options
        );
    }
}
