<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreDoctrine\Site\Entity\SiteUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NewSiteUid implements \Zrcms\Core\Site\Api\NewSiteUid
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * Unique identifier
     *
     * @param array $options
     *
     * @return string
     */
    public function __invoke(array $options = []): string
    {
        $uid = new SiteUid();

        $this->entityManager->persist($uid);
        $this->entityManager->flush($uid);

        return $uid->__toString();
    }
}
