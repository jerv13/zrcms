<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Phly\Mustache\Mustache;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\Layout;
use Zrcms\Mustache\StringResolver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutMustache implements RenderLayout
{
    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
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
