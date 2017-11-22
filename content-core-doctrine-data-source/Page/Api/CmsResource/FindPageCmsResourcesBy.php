<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            PageCmsResourceEntity::class,
            PageCmsResourceBasic::class,
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
     * @return PageCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
