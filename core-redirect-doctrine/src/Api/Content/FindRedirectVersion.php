<?php

namespace Zrcms\CoreRedirectDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersion extends FindContentVersion implements \Zrcms\CoreRedirect\Api\Content\FindRedirectVersion
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
