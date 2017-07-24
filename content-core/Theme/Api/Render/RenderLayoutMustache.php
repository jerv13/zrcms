<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Phly\Mustache\Mustache;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\Mustache\StringResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutMustache implements RenderLayout
{
    /**
     * @param Layout|Content $layout
     * @param array          $renderData ['render-tag' => '{html}']
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        array $renderData,
        array $options = []
    ): string
    {
        $resolver = new StringResolver();
        $resolver->addTemplate('template', $layout->getHtml());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderData);
    }
}
