<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResource;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResource
    extends FindCmsResource
    implements \Zrcms\ContentRedirect\Api\CmsResource\FindRedirectCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            RedirectCmsResourceEntity::class,
            RedirectCmsResourceBasic::class,
            RedirectVersionEntity::class,
            RedirectVersionBasic::class,
            []
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return RedirectCmsResource|CmsResource|null
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
