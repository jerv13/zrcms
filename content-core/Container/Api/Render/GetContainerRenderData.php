<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;

/**
 * renderDataService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerRenderData extends GetContentRenderData
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
