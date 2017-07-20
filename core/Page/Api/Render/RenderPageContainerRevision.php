<?php

namespace Zrcms\Core\Page\Api\Render;

use Zrcms\Content\Api\Render\RenderContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Page\Model\PageContainerRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPageContainerRevision extends RenderContentRevision
{
    /**
     * @param PageContainerRevision|ContentRevision $pageContainerRevision
     * @param array                                 $renderData ['templateTag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $pageContainerRevision,
        array $renderData,
        array $options = []
    ): string;
}
