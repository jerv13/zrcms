<?php

namespace Zrcms\ContentDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstractCmsResource extends ApiAbstract
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $classCmsResourceBasic
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $classCmsResourceBasic
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResource,
            CmsResource::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = $entityClassCmsResource;
        $this->classCmsResourceBasic = $classCmsResourceBasic;
    }
}
