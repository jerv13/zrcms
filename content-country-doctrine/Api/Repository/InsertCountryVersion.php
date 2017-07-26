<?php

namespace Zrcms\ContentCountryDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCountry\Model\CountryVersion;
use Zrcms\ContentCountry\Model\CountryVersionBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertCountryVersion
    extends InsertContentVersion
    implements \Zrcms\ContentCountry\Api\Repository\InsertCountryVersion
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
     * @param CountryVersion|ContentVersion $countryVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $countryVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $countryVersion,
            $options
        );
    }
}
