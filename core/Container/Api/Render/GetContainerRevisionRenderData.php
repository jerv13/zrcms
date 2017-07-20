<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRevisionRenderData;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Container\Model\ContainerRevision;

/**
 * renderDataService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerRevisionRenderData extends GetContentRevisionRenderData
{
    /**
     * @param ContentRevision|ContainerRevision $containerRevision
     * @param ServerRequestInterface            $request
     * @param array                             $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        ContentRevision $containerRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
