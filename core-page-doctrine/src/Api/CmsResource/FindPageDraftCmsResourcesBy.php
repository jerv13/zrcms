<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageDraftCmsResourcesBy as CoreFindBy;
use Zrcms\CorePage\Model\PageDraftCmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageDraftCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageDraftCmsResourcesBy extends FindCmsResourcesBy implements CoreFindBy
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
            PageDraftCmsResourceEntity::class,
            PageDraftCmsResourceBasic::class,
            PageVersionEntity::class,
            PageVersionBasic::class,
            []
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return PageDraftCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
