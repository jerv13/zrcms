<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRevisionRenderData;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Page\Model\PageContainerRevision;

/**
 * renderDataService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageContainerRevisionRenderData extends GetContentRevisionRenderData
{
    /**
     * @param PageContainerRevision|ContentRevision $pageContainerRevision
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        ContentRevision $pageContainerRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
