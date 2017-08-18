<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentRedirect\Model\RedirectVersion;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertRedirectVersion
    extends InsertContentVersion
    implements \Zrcms\ContentRedirect\Api\Repository\InsertRedirectVersion
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
