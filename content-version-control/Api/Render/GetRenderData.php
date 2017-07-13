<?php

namespace Zrcms\ContentVersionControl\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetRenderData
{
    /**
     * @param Content                $content
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $content,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
