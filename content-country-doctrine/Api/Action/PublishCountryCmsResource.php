<?php

namespace Zrcms\ContentCountryDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResourceBasic;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourceEntity;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourcePublishHistoryEntity;
use Zrcms\ContentCountryDoctrine\Entity\CountryVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishCountryCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCountry\Api\Action\PublishCountryCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            CountryCmsResourceEntity::class,
            CountryCmsResourcePublishHistoryEntity::class,
            CountryVersionEntity::class,
            CountryCmsResourceBasic::class
        );
    }

    /**
     * @param CountryCmsResource|CmsResource $countryCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $countryCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $countryCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
