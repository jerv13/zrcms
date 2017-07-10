<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Api\NewPageUid;
use Zrcms\Core\Page\Model\PageDraft;
use Zrcms\Uid\Api\NewUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePageDraft implements \Zrcms\Core\Page\Api\CreatePageDraft
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NewPageUid
     */
    protected $newPageUid;

    /**
     * @param EntityManager $entityManager
     * @param NewPageUid    $newPageUid
     */
    public function __construct(
        EntityManager $entityManager,
        NewPageUid $newPageUid
    ) {
        $this->entityManager = $entityManager;
        $this->newPageUid = $newPageUid;
    }

    /**
     * @param string $uri
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return PageDraft
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): PageDraft
    {
        $page = new \Zrcms\CoreDoctrine\Page\Entity\PageDraft(
            $this->newPageUid->__invoke(),
            $uri,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush($page);

        return $page;
    }
}
