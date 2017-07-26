<?php

namespace Zrcms\ContentLanguageDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResourceBasic;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageCmsResourceEntity;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageCmsResourcePublishHistoryEntity;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishLanguageCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentLanguage\Api\Action\PublishLanguageCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LanguageCmsResourceEntity::class,
            LanguageCmsResourcePublishHistoryEntity::class,
            LanguageVersionEntity::class,
            LanguageCmsResourceBasic::class
        );
    }

    /**
     * @param LanguageCmsResource|CmsResource $languageCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $languageCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $languageCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
