<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderViewLayout implements RenderView
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
     * @param array        $renderData ['render-tag' => '{html}']
     * @param array        $options
     *
     * @return string
     */
    public function __invoke(
        Content $view,
        array $renderData,
        array $options = []
    ): string
    {
        return $this->renderLayout->__invoke(
            $view->getLayout(),
            $renderData,
            $options
        );
    }
}
