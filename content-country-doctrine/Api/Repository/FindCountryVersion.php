<?php

namespace Zrcms\ContentCountryDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCountry\Model\CountryVersionBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCountryVersion
    extends FindContentVersion
    implements \Zrcms\ContentCountry\Api\Repository\FindCountryVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return CountryVersionBasic|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        parent::__invoke(
            $id,
            $options
        );
    }
}
