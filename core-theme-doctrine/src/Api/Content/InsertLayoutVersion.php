<?php

namespace Zrcms\CoreThemeDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreTheme\Model\LayoutVersion;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\InsertContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertLayoutVersion
    extends InsertContentVersion
    implements \Zrcms\CoreTheme\Api\Content\InsertLayoutVersion
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class
        );
    }

    /**
     * @param LayoutVersion|ContentVersion $layoutVersion
     * @param array                           $options
     *
     * @return LayoutVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $layoutVersion,
        array $options = []
    ): ContentVersion
    {
        return parent::__invoke(
            $layoutVersion,
            $options
        );
    }
}
