<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreDoctrine\Page\Entity\PageUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NewPageUid implements \Zrcms\Core\Page\Api\NewPageUid
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
     * Unique identifier
     *
     * @param array $options
     *
     * @return string
     */
    public function __invoke(array $options = []): string
    {
        $uid = new PageUid();

        $this->entityManager->persist($uid);
        $this->entityManager->flush($uid);

        return $uid->__toString();
    }
}
