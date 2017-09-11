<?php

namespace Zrcms\ContentDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstractCmsResource extends ApiAbstract
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var string
     */
    protected $classCmsResourceBasic;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var array
     */
    protected $cmsResourceSyncToProperties = [];

    /**
     * @var array
     */
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResource
     * @param string        $classCmsResourceBasic
     * @param string        $entityClassContentVersion
     * @param string        $classContentVersionBasic
     * @param array         $cmsResourceSyncToProperties
     * @param array         $contentVersionSyncToProperties
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResource,
            CmsResource::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = $entityClassCmsResource;
        $this->classCmsResourceBasic = $classCmsResourceBasic;

        $this->entityClassContentVersion = $entityClassContentVersion;
        $this->classContentVersionBasic = $classContentVersionBasic;

        $this->cmsResourceSyncToProperties = $cmsResourceSyncToProperties;
        $this->contentVersionSyncToProperties = $contentVersionSyncToProperties;
    }
}
