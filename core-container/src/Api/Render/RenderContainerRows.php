<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerVersion;

class RenderContainerRows implements RenderContainer
{
    protected $renderBlock;
    protected $wrapRenderedContainer;
    protected $debug;

    /**
     * @param RenderBlock                                           $renderBlock
     * @param \Zrcms\CoreContainer\Api\Render\WrapRenderedContainer $wrapRenderedContainer
     * @param bool                                                  $debug
     */
    public function __construct(
        RenderBlock $renderBlock,
        WrapRenderedContainer $wrapRenderedContainer,
        bool $debug = false
    ) {
        $this->renderBlock = $renderBlock;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
        $this->debug = $debug;
    }

    /**
     * @param Container|ContainerVersion|Content $container
     * @param array                              $renderTags ['render-tag' => '{html}']
     * @param array                              $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderTags,
        array $options = []
    ): string {
        $containerInnerHtml = '';

        if ($this->debug) {
            $containerInnerHtml .= '<!-- <container: ' . $container->getId() . '> -->';
        }

        foreach ($renderTags as $row) {
            $containerInnerHtml .= "\n<div class=\"row\">\n";
            if (is_array($row)) {
                foreach ($row as $block) {
                    $containerInnerHtml .= $block;
                }
            } else {
                $containerInnerHtml .= (string)$row;
            }
            $containerInnerHtml .= "\n</div>\n";
        }

        if ($this->debug) {
            $containerInnerHtml .= '<!-- </container: ' . $container->getId() . '> -->';
        }

        return $this->wrapRenderedContainer->__invoke(
            $containerInnerHtml,
            $container
        );
    }
}
