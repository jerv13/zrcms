<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageCmsResource
    extends FindCmsResource
    implements \Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
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
     * @param string $id
     * @param array  $options
     *
     * @return PageCmsResource|CmsResource|null
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
