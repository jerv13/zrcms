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
    protected $entityClass;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClass
     * @param string        $classCmsResourceBasic
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClass,
        string $classCmsResourceBasic
    ) {
        $this->assertValidEntityClass(
            $entityClass,
            CmsResource::class
        );

        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->classCmsResourceBasic = $classCmsResourceBasic;
    }
}
