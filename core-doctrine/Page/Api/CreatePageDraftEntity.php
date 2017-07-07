<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Api\CreatePageDraft;
use Zrcms\Core\Page\Model\PageDraft;
use Zrcms\Core\Uid\Api\NewUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePageDraftEntity implements CreatePageDraft
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
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $blockInstances
     * @param array  $options
     *
     * @return PageDraft
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $blockInstances,
        array $options = []
    ): PageDraft
    {
        $page = new \Zrcms\CoreDoctrine\Page\Entity\PageDraft(
            $uri,
            $properties,
            $blockInstances,
            $createdByUserId,
            $createdReason,
            $this->newUid->__invoke()
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush($page);

        return $page;
    }
}
