<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Site\Api\NewSiteUid;
use Zrcms\ContentCore\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreateSitePublished implements \Zrcms\ContentCore\Site\Api\CreateSitePublished
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NewSiteUid
     */
    protected $newSiteUid;

    /**
     * @param EntityManager $entityManager
     * @param NewSiteUid        $newSiteUid
     */
    public function __construct(
        EntityManager $entityManager,
        NewSiteUid $newSiteUid
    ) {
        $this->entityManager = $entityManager;
        $this->newSiteUid = $newSiteUid;
    }

    /**
     * @param string $host
     * @param string $theme
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
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
        array $options = []
    ): SitePublished
    {
        $newSite = new \Zrcms\CoreDoctrine\Site\Entity\SitePublished(
            $this->newSiteUid->__invoke(),
            $host,
            $theme,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->entityManager->persist($newSite);
        $this->entityManager->flush($newSite);

        return $newSite;
    }
}
