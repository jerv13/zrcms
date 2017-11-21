<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResource;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageTemplateCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageTemplateCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            PageTemplateCmsResourceEntity::class,
            PageTemplateCmsResourceBasic::class,
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
     * @return PageTemplateCmsResource[]
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
