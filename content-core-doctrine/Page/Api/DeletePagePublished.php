<?php

namespace Zrcms\ContentCoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Model\PageDeleted;
use Zrcms\ContentCore\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DeletePagePublished implements \Zrcms\ContentCore\Page\Api\DeletePagePublished
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
        $newPage = new \Zrcms\ContentCoreDoctrine\Page\Entity\PageDeleted(
            $page->getUid(),
            $page->getUri(),
            $page->getProperties(),
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
