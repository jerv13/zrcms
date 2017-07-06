<?php

namespace Rcms\Core\Page\Api;

use Doctrine\ORM\EntityManager;
use Rcms\Core\Page\Model\PageDeleted;
use Rcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeletePagePublishedEntity implements DeletePagePublished
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
     * @param PagePublished $page
     * @param string        $modifiedByUserId
     * @param string        $modifiedReason
     * @param array         $options
     *
     * @return PageDeleted
     */
    public function __invoke(
        PagePublished $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PageDeleted
    {
        $newPage = new \Rcms\Core\Page\Entity\PageDeleted(
            $page->getUrl(),
            $page->getProperties(),
            $page->getBlockInstances(),
            $modifiedByUserId,
            $modifiedByUserId,
            $page->getTrackingId()
        );

        $this->entityManager->persist($newPage);
        $this->entityManager->flush($newPage);

        $this->entityManager->remove($page);
        $this->entityManager->flush($page);

        return $newPage;
    }
}
