<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Site\Api\Content\FindSiteVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteVersionEntity::class,
            SiteVersionBasic::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteVersionBasic|ContentVersion|null
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
