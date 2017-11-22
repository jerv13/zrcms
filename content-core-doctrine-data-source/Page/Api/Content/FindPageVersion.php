<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Page\Api\Content\FindPageVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return PageVersionBasic|ContentVersion|null
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
