<?php

namespace Zrcms\CoreDoctrine\Uid\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreDoctrine\Uid\Entity\Uid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NewUid implements \Zrcms\Core\Uid\Api\NewUid
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
    public function __invoke(array $options = [])
    {
        $uid = new Uid();

        $this->entityManager->persist($uid);
        $this->entityManager->flush($uid);

        return $uid->__toString();
    }
}
