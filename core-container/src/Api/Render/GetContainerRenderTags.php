<?php

namespace Zrcms\CoreContainer\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\GetContentRenderTags;
use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Model\Container;

/**
 * renderTagsService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerRenderTags extends GetContentRenderTags
{
    /**
     * @param Content|Container      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
