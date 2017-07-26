<?php

namespace Zrcms\ContentCountryDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCountry\Model\CountryVersionBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountryVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCountry\Api\Repository\FindCountryVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            CountryVersionEntity::class,
            CountryVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CountryVersionBasic[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
