<?php

namespace Zrcms\CoreView\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Api\Render\RenderLayout;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderViewLayout implements RenderView, RenderLayout
{
    /**
     * @var RenderLayout
     */
    protected $renderLayout;

    /**
     * @param RenderLayout $renderLayout
     */
    public function __construct(
        RenderLayout $renderLayout
    ) {
        $this->renderLayout = $renderLayout;
    }

    /**
     * @param View|Content $view
     * @param array        $renderTags ['render-tag' => '{html}']
     * @param array        $options
     *
     * @return string
     */
    public function __invoke(
        Content $view,
        array $renderTags,
        array $options = []
    ): string {
        return $this->renderLayout->__invoke(
            $view->getLayoutCmsResource()->getContentVersion(),
            $renderTags,
            $options
        );
    }
}
