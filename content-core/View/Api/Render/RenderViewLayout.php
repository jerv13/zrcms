<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\View\Model\View;

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
    ): string
    {
        return $this->renderLayout->__invoke(
            $view->getLayout(),
            $renderTags,
            $options
        );
    }
}
