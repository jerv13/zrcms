<?php

namespace Zrcms\CoreRedirectDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreRedirect\Model\RedirectVersion;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertRedirectVersion
    extends InsertContentVersion
    implements \Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion
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
     * @param RedirectVersion|ContentVersion $redirectVersion
     * @param array                           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $redirectVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $redirectVersion,
            $options
        );
    }
}
