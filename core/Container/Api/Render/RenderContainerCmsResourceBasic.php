<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\BlockInstance\Api\Render\RenderBlockInstance;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;

class RenderContainerCmsResourceBasic implements RenderContainerCmsResource
{
    protected $renderBlockInstance;
    protected $wrapRenderedContainer;

    /**
     * @param RenderBlockInstance   $renderBlockInstance
     * @param WrapRenderedContainer $wrapRenderedContainer
     */
    public function __construct(
        RenderBlockInstance $renderBlockInstance,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->renderBlockInstance = $renderBlockInstance;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param Container|CmsResource $container
     * @param array                 $renderData ['templateTag' => '{html}']
     * @param array                 $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $container,
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
            $container
        );
    }
}
