<?php

namespace Rcms\Core\Page\Api;

use Doctrine\ORM\EntityManager;
use Rcms\Core\Page\Model\PageDraft;
use Rcms\Core\Uid\Api\NewUid;

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
     * @param string $url
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $blockInstances
     * @param array  $options
     *
     * @return PageDraft
     */
    public function __invoke(
        string $url,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $blockInstances,
        array $options = []
    ): PageDraft
    {
        $page = new \Rcms\Core\Page\Entity\PageDraft(
            $url,
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
