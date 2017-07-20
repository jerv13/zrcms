<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Api\NewPageUid;
use Zrcms\Core\Page\Model\PagePublished;
use Zrcms\Core\Page\Model\PageTemplate;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePagePublished implements \Zrcms\Core\Page\Api\CreatePagePublished
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
     * @param NewPageUid        $newPageUid
     */
    public function __construct(
        EntityManager $entityManager,
        NewPageUid $newPageUid
    ) {
        $this->entityManager = $entityManager;
        $this->newPageUid = $newPageUid;
    }

    /**
     * @param string $id
     * @param string $createdByUserId
     * @param string $createdReason
     * @param array  $properties
     * @param array  $options
     *
     * @return PagePublished
     */
    public function __invoke(
        string $id,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): PagePublished
    {
        $page = new \Zrcms\CoreDoctrine\Page\Entity\PagePublished(
            $this->newPageUid->__invoke(),
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush($page);

        return $page;
    }
}
