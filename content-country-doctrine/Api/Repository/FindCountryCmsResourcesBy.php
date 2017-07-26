<?php

namespace Zrcms\ContentCountryDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCountry\Model\CountryCmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResourceBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountryCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\Content\Api\Repository\FindCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            CountryCmsResourceEntity::class,
            CountryCmsResourceBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CountryCmsResource[]
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
