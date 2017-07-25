<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageContainerVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return PageContainerVersionBasic|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        parent::__invoke(
            $id,
            $options
        );
    }
}
