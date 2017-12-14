<?php

namespace Zrcms\CoreRedirectDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersionsBy extends FindContentVersionsBy implements \Zrcms\CoreRedirect\Api\Content\FindRedirectVersionsBy
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return RedirectVersionBasic[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
