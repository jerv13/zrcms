<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersion;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersion as ParentFind;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteContainerVersion extends FindContentVersion implements ParentFind
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
     * @param string $id
     * @param array  $options
     *
     * @return ContainerVersionBasic|ContentVersion|null
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
