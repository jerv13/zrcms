<?php

namespace Zrcms\Content\Api\Render;

use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContentRevision
{
    /**
     * @param ContentRevision $contentRevision
     * @param array           $renderData ['templateTag' => '{html}']
     * @param array           $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $contentRevision,
        array $renderData,
        array $options = []
    ): string;
}
