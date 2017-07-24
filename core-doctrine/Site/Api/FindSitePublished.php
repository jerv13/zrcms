<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSitePublished implements \Zrcms\ContentCore\Site\Api\FindSitePublished
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
     * @param string $host
     * @param array  $options
     *
     * @return SitePublished|null
     */
    public function __invoke(
        string $host,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            \Zrcms\CoreDoctrine\Site\Entity\SitePublished::class
        );

        return $repository->find(
            $host
        );
    }
}
