<?php

namespace Zrcms\CoreSiteDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreSite\Model\SiteVersion;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertSiteVersion extends InsertContentVersion implements \Zrcms\CoreSite\Api\Content\InsertSiteVersion
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
    ): ContentVersion {
        return parent::__invoke(
            $siteVersion,
            $options
        );
    }
}
