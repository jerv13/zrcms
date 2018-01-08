<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResourceHistory;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResourceHistory\FindCmsResourceHistoryBy;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistoryBy as CoreFindPageCmsResourceHistoryBy;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageCmsResourceHistoryBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceHistoryEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResourceHistoryBy extends FindCmsResourceHistoryBy implements CoreFindPageCmsResourceHistoryBy
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            PageCmsResourceHistoryEntity::class,
            PageCmsResourceHistoryBasic::class,
            PageCmsResourceEntity::class,
            PageCmsResourceBasic::class,
            PageVersionEntity::class,
            PageVersionBasic::class
        );
    }
}
