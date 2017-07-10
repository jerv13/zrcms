<?php

namespace Zrcms\CountryDoctrine\Api;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountriesPublishedBy implements \Zrcms\Country\Api\FindCountriesPublishedBy
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [CountryPublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        $repository = $this->entityManager->getRepository(
            \Zrcms\CountryDoctrine\Country\Entity\CountryPublished::class
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
