<?php

namespace Zrcms\ContentLanguageDoctrine\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageCmsResourceEntity;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageCmsResourcePublishHistoryEntity;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishLanguageCmsResource
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
            LanguageCmsResourceEntity::class,
            LanguageCmsResourcePublishHistoryEntity::class,
            LanguageVersionEntity::class
        );
    }

    /**
     * @param LanguageCmsResource|CmsResource $languageCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $languageCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $languageCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
