<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResourceBasic;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResource
    extends FindCmsResource
    implements \Zrcms\Content\Api\Repository\FindCmsResource
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
            RedirectCmsResourceBasic::class
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
