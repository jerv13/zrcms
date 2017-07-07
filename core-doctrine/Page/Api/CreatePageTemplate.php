<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Model\PageTemplate;
use Zrcms\Core\Uid\Api\NewUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CreatePageTemplate implements \Zrcms\Core\Page\Api\CreatePageTemplate
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
     * @return PageTemplate
     */
    public function __invoke(
        string $uri,
        string $createdByUserId,
        string $createdReason,
        array $properties,
        array $blockInstances,
        array $options = []
    ): PageTemplate
    {
        $page = new \Zrcms\CoreDoctrine\Page\Entity\PageTemplate(
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
