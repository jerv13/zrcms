<?php

namespace Zrcms\CorePageDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageVersion extends FindContentVersion implements \Zrcms\CorePage\Api\Content\FindPageVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageVersionEntity::class,
            PageVersionBasic::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageVersionBasic|ContentVersion|null
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
