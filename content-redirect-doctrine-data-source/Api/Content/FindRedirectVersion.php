<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersion
    extends FindContentVersion
    implements \Zrcms\ContentRedirect\Api\Content\FindRedirectVersion
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
