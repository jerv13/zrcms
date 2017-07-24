<?php

namespace Zrcms\ContentCoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Model\PageDraft;
use Zrcms\ContentCore\Page\Model\PagePublished;
use Zrcms\ContentCoreDoctrine\Page\Entity\PageHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageDraft implements \Zrcms\ContentCore\Page\Api\PublishPageDraft
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
        $existingPage = $pagePublishedRepository->find($page->getUri());

        if ($existingPage) {
            $pageHistory = new PageHistory(
                $existingPage->getUid(),
                $existingPage->getUri(),
                $existingPage->getProperties(),
                $modifiedByUserId,
                $modifiedReason
            );

            $this->entityManager->persist($pageHistory);
            $this->entityManager->flush($pageHistory);

            $this->entityManager->remove($existingPage);
            $this->entityManager->flush($existingPage);
        }

        $newPage = new \Zrcms\ContentCoreDoctrine\Page\Entity\PagePublished(
            $page->getUid(),
            $page->getUri(),
            $page->getProperties(),
            $modifiedByUserId,
            $modifiedReason
        );

        $this->entityManager->persist($newPage);
        $this->entityManager->flush($newPage);

        $this->entityManager->remove($page);
        $this->entityManager->flush($page);

        return $newPage;
    }
}