<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Model\PageHistory;
use Zrcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageHistory implements \Zrcms\Core\Page\Api\PublishPageHistory
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
        $existingPage = $pagePublishedRepository->find($page->getUri());

        if ($existingPage) {
            $pageHistory = new \Zrcms\CoreDoctrine\Page\Entity\PageHistory(
                $existingPage->getUid(),
                $existingPage->getUri(),
                $existingPage->getProperties(),
                $existingPage->getBlockInstances(),
                $modifiedByUserId,
                $modifiedReason
            );

            $this->entityManager->persist($pageHistory);
            $this->entityManager->flush($pageHistory);

            $this->entityManager->remove($existingPage);
            $this->entityManager->flush($existingPage);
        }

        $newPage = new \Zrcms\CoreDoctrine\Page\Entity\PagePublished(
            $page->getUid(),
            $page->getUri(),
            $page->getProperties(),
            $page->getBlockInstances(),
            $modifiedByUserId,
            $modifiedByUserId
        );

        $this->entityManager->persist($newPage);
        $this->entityManager->flush($newPage);

        $this->entityManager->remove($page);
        $this->entityManager->flush($page);

        return $newPage;
    }
}
