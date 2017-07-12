<?php

namespace Zrcms\ContentVersionControl\Api;

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
     * @return string
     */
    public function __invoke(
        Content $content,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
