<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertSiteVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCore\Site\Api\Content\InsertSiteVersion
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
     * @param SiteVersion|ContentVersion $siteVersion
     * @param array                           $options
     *
     * @return SiteVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $siteVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $siteVersion,
            $options
        );
    }
}
