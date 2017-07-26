<?php

namespace Zrcms\ContentCountryDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourceEntity;
use Zrcms\ContentCountryDoctrine\Entity\CountryCmsResourcePublishHistoryEntity;
use Zrcms\ContentCountryDoctrine\Entity\CountryVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishCountryCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\Content\Api\Action\UnpublishCmsResource
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
            CountryVersionEntity::class
        );
    }

    /**
     * @param CountryCmsResource|CmsResource $countryCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $countryCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $countryCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
