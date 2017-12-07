<?php

namespace Zrcms\CoreTheme\Api\Render;

use Phly\Mustache\Mustache;
use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Model\Layout;
use Zrcms\Mustache\Resolver\StringResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutMustache implements RenderLayout
{
    /**
     * @param Layout|Content $layout
     * @param array          $renderTags ['render-tag' => '{html}']
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        array $renderTags,
        array $options = []
    ): string
    {
        $resolver = new StringResolver();
        $resolver->addTemplate('template', $layout->getHtml());

        $mustache = new Mustache();
        $mustache->getResolver()->attach($resolver);

        return $mustache->render('template', $renderTags);
    }
}
