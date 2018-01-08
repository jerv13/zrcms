<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;
use Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstractCmsResourceHistory extends ApiAbstract
{
    protected $entityManager;
    protected $entityClassCmsResourceHistory;
    protected $classCmsResourceHistoryBasic;
    protected $entityClassCmsResource;
    protected $classCmsResourceBasic;
    protected $entityClassContentVersion;
    protected $classContentVersionBasic;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityClassCmsResourceHistory
     * @param string        $classCmsResourceHistoryBasic
     * @param string        $entityClassCmsResource
     * @param string        $classCmsResourceBasic
     * @param string        $entityClassContentVersion
     * @param string        $classContentVersionBasic
     *
     * @throws InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager,
        string $entityClassCmsResourceHistory,
        string $classCmsResourceHistoryBasic,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic
    ) {
        $this->assertValidEntityClass(
            $entityClassCmsResourceHistory,
            CmsResourceHistoryEntity::class
        );

        $this->entityManager = $entityManager;
        $this->entityClassCmsResourceHistory = $entityClassCmsResourceHistory;
        $this->classCmsResourceHistoryBasic = $classCmsResourceHistoryBasic;

        $this->entityClassCmsResource = $entityClassCmsResource;
        $this->classCmsResourceBasic = $classCmsResourceBasic;

        $this->entityClassContentVersion = $entityClassContentVersion;
        $this->classContentVersionBasic = $classContentVersionBasic;
    }
}
