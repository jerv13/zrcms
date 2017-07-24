<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Api\NewPageUid;
use Zrcms\ContentCore\Page\Model\PageTemplate;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePageTemplate implements \Zrcms\ContentCore\Page\Api\CreatePageTemplate
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
     * @return PageTemplate
     */
    public function __invoke(
        string $id,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $options = []
    ): PageTemplate
    {
        $page = new \Zrcms\CoreDoctrine\Page\Entity\PageTemplate(
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
