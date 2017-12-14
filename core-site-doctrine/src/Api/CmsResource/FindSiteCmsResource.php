<?php

namespace Zrcms\CoreSiteDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResource extends FindCmsResource implements \Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteCmsResourceEntity::class,
            SiteCmsResourceBasic::class,
            SiteVersionEntity::class,
            SiteVersionBasic::class,
            []
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteCmsResource|CmsResource|null
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
