<?php

namespace Zrcms\CountryDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Country\Model\CountryPublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountryPublished implements \Zrcms\Country\Api\FindCountryPublished
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
     * @param          $iso3
     * @param array    $options
     *
     * @return CountryPublished|null
     */
    public function __invoke(
        $iso3,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            \Zrcms\CountryDoctrine\Country\Entity\CountryPublished::class
        );

        return $repository->find(
            $iso3
        );
    }
}
