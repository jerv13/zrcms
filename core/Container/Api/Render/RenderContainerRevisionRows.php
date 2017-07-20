<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\Content\Api\Render\RenderContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\Render\RenderBlockRevision;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\ContainerRevision;

class RenderContainerRevisionRows implements RenderContentRevision
{
    /**
     * @var RenderBlockRevision
     */
    protected $renderBlockRevision;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param RenderBlockRevision   $renderBlockRevision
     * @param WrapRenderedContainer $wrapRenderedContainer
     */
    public function __construct(
        RenderBlockRevision $renderBlockRevision,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->renderBlockRevision = $renderBlockRevision;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

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
    ): string
    {
        $containerInnerHtml = '';
        foreach ($renderData as $row) {
            $containerInnerHtml .= '<div class="row">';
            foreach ($row as $block) {
                $containerInnerHtml .= $block;
            }
            $containerInnerHtml .= '</div>';
        }

        return $this->wrapRenderedContainer->__invoke(
            $containerInnerHtml,
            $containerRevision
        );
    }
}
