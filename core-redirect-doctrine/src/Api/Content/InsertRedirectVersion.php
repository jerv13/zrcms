<?php

namespace Zrcms\CoreRedirectDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion as CoreInsert;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertRedirectVersion extends InsertContentVersion implements CoreInsert
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            RedirectVersionEntity::class,
            RedirectVersionBasic::class
        );
    }

    /**
     * @param ContentVersion $redirectVersion
     * @param array          $options
     *
     * @return ContentVersion
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\IdMustBeEmptyException
     */
    public function __invoke(
        ContentVersion $redirectVersion,
        array $options = []
    ): ContentVersion {
        return parent::__invoke(
            $redirectVersion,
            $options
        );
    }
}
