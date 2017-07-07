<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Site\Model\SitePublished;
use Zrcms\Core\Uid\Api\NewUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateSitePublished implements \Zrcms\Core\Site\Api\CreateSitePublished
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NewUid
     */
    protected $newUid;

    /**
     * @param EntityManager $entityManager
     * @param NewUid        $newUid
     */
    public function __construct(
        EntityManager $entityManager,
        NewUid $newUid
    ) {
        $this->entityManager = $entityManager;
        $this->newUid = $newUid;
    }

    /**
     * @param string $host
     * @param string $theme
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $id
     * @param array  $options
     *
     * @return SitePublished
     */
    public function __invoke(
        string $host,
        string $theme,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $id = null,
        array $options = []
    ): SitePublished
    {
        $newSite = new \Zrcms\CoreDoctrine\Site\Entity\SitePublished(
            $host,
            $theme,
            $properties,
            $createdByUserId,
            $createdReason,
            $this->newUid->__invoke(),
            $id = null
        );

        $this->entityManager->persist($newSite);
        $this->entityManager->flush($newSite);

        return $newSite;
    }
}
