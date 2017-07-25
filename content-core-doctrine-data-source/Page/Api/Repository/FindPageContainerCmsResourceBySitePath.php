<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageContainerCmsResourceBySitePath
    implements \Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = PageContainerCmsResourceEntity::class;
        $this->classCmsResourceBasic = PageContainerCmsResourceBasic::class;
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $pageContainerCmsResourcePath
     * @param array  $options
     *
     * @return PageContainerCmsResource|CmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $pageContainerCmsResourcePath,
        array $options = []
    ) {

    }
}
