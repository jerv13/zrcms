<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageDraftCmsResource as CoreFind;
use Zrcms\CorePage\Model\PageDraftCmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageDraftCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageDraftCmsResource extends FindCmsResource implements CoreFind
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager
    ) {
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
     * @param string $id
     * @param array  $options
     *
     * @return PageDraftCmsResource|CmsResource|null
     * @throws \Exception
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
