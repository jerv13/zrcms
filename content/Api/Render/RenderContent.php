<?php

namespace Zrcms\Content\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContent
{
    /**
     * @param Content                $content
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $content,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
