<?php

namespace Zrcms\ContentLanguageDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentLanguage\Model\LanguageVersion;
use Zrcms\ContentLanguage\Model\LanguageVersionBasic;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertLanguageVersion
    extends InsertContentVersion
    implements \Zrcms\ContentLanguage\Api\Repository\InsertLanguageVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LanguageVersionEntity::class,
            LanguageVersionBasic::class
        );
    }

    /**
     * @param LanguageVersion|ContentVersion $languageVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $languageVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $languageVersion,
            $options
        );
    }
}
