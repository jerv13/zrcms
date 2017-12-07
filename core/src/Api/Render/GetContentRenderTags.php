<?php

namespace Zrcms\Core\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContentRenderTags
{
    /**
     * @param Content                $content
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $content,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
