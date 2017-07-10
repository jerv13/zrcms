<?php

namespace Zrcms\CountryDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\CountryDoctrine\Country\Entity\CountryUid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class NewCountryUid implements \Zrcms\Country\Api\NewCountryUid
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
        $uid = new CountryUid();

        $this->entityManager->persist($uid);
        $this->entityManager->flush($uid);

        return $uid->__toString();
    }
}
