<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Api\FallbackToComponentLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutVersion
    extends FindContentVersion
    implements \Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersion
{
    /**
     * @var FallbackToComponentLayoutVersion
     */
    protected $fallbackToComponentLayoutVersion;

    /**
     * @param EntityManager                    $entityManager
     * @param FallbackToComponentLayoutVersion $fallbackToComponentLayoutVersion
     */
    public function __construct(
        EntityManager $entityManager,
        FallbackToComponentLayoutVersion $fallbackToComponentLayoutVersion
    ) {
        $this->fallbackToComponentLayoutVersion = $fallbackToComponentLayoutVersion;

        parent::__construct(
            $entityManager,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return LayoutVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        /** @var LayoutVersion $layoutVersion */
        $layoutVersion = parent::__invoke(
            $id,
            $options
        );

        // @todo REMOVE FALLBACK?
        return $this->fallbackToComponentLayoutVersion->__invoke(
            $layoutVersion,
            $id,
            $options
        );
    }
}
