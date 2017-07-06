<?php

namespace Rcms\Core\Page\Api;

use Doctrine\ORM\EntityManager;
use Rcms\Core\Page\Entity\PageHistory;
use Rcms\Core\Page\Model\PageDraft;
use Rcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageDraftEntity implements PublishPageDraft
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
     * @param PageDraft $page
     * @param string    $modifiedByUserId
     * @param string    $modifiedReason
     * @param array     $options
     *
     * @return PagePublished
     */
    public function __invoke(
        PageDraft $page,
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
            $pageHistory = new PageHistory(
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
            $modifiedReason,
            $page->getTrackingId()
        );

        $this->entityManager->persist($newPage);
        $this->entityManager->flush($newPage);

        $this->entityManager->remove($page);
        $this->entityManager->flush($page);

        return $newPage;
    }
}
