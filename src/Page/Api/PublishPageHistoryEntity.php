<?php

namespace Rcms\Core\Page\Api;

use Doctrine\ORM\EntityManager;
use Rcms\Core\Page\Entity\PagePublished;
use Rcms\Core\Page\Model\PageHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageHistoryEntity implements PublishPageHistory
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
     * @param PageHistory $page
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param array       $options
     *
     * @return PagePublished
     */
    public function __invoke(
        PageHistory $page,
        string $modifiedByUserId,
        string $modifiedReason,
        array $options = []
    ): PagePublished
    {
        $pagePublishedRepository = $this->entityManager->getRepository(
            PagePublished::class
        );

        /** @var PagePublished $existingPage */
        $existingPage = $pagePublishedRepository->find($page->getUrl());

        if ($existingPage) {
            $pageHistory = new \Rcms\Core\Page\Entity\PageHistory(
                $existingPage->getUrl(),
                $existingPage->getProperties(),
                $existingPage->getBlockInstances(),
                $modifiedByUserId,
                $modifiedReason,
                $existingPage->getTrackingId()
            );

            $this->entityManager->persist($pageHistory);
            $this->entityManager->flush($pageHistory);

            $this->entityManager->remove($existingPage);
            $this->entityManager->flush($existingPage);
        }

        $newPage = new \Rcms\Core\Page\Entity\PagePublished(
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
