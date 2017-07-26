<?php

namespace Zrcms\ContentLanguageDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentLanguage\Model\LanguageVersionBasic;
use Zrcms\ContentLanguageDoctrine\Entity\LanguageVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLanguageVersion
    extends FindContentVersion
    implements \Zrcms\ContentLanguage\Api\Repository\FindLanguageVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return LanguageVersionBasic|ContentVersion|null
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
