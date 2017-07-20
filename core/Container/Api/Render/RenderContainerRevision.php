<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\Content\Api\Render\RenderContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Container\Model\ContainerRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainerRevision extends RenderContentRevision
{
    /**
     * @param ContainerRevision|ContentRevision $containerRevision
     * @param array                             $renderData ['templateTag' => '{html}']
     * @param array                             $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $containerRevision,
        array $renderData,
        array $options = []
    ): string;
}
