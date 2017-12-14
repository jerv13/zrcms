<?php

namespace Zrcms\CoreThemeDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreTheme\Model\LayoutVersion;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutVersion;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutVersion extends FindContentVersion implements \Zrcms\CoreTheme\Api\Content\FindLayoutVersion
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
