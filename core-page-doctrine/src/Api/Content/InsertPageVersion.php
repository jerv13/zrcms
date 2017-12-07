<?php

namespace Zrcms\CorePageDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertPageVersion
    extends InsertContentVersion
    implements \Zrcms\CorePage\Api\Content\InsertPageVersion
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
     * @param PageVersion|ContentVersion $pageVersion
     * @param array                      $options
     *
     * @return PageVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $pageVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $pageVersion,
            $options
        );
    }
}
