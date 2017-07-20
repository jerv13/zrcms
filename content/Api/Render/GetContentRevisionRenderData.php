<?php

namespace Zrcms\Content\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContentRevisionRenderData
{
    /**
     * @param ContentRevision        $contentRevision
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        ContentRevision $contentRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
