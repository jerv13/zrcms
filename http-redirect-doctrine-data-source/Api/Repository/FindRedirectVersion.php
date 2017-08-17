<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\HttpRedirect\Redirect\Model\RedirectVersionBasic;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersion
    extends FindContentVersion
    implements \Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectVersion
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
     * @param string $id
     * @param array  $options
     *
     * @return RedirectVersionBasic|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        return parent::__invoke(
            $id,
            $options
        );
    }
}
