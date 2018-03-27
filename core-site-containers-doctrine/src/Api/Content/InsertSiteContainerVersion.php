<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion as ParentInsert;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertSiteContainerVersion extends InsertContentVersion implements ParentInsert
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteContainerVersionEntity::class,
            ContainerVersionBasic::class
        );
    }

    /**
     * @param ContentVersion $containerVersion
     * @param array          $options
     *
     * @return ContentVersion
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ContentVersion $containerVersion,
        array $options = []
    ): ContentVersion {
        return parent::__invoke(
            $containerVersion,
            $options
        );
    }
}
