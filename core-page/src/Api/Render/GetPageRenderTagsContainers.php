<?php

namespace Zrcms\CorePage\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CorePage\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageRenderTagsContainers implements GetPageRenderTags
{
    const SERVICE_ALIAS = 'containers';

    protected $getContainerRenderTags;
    protected $renderContainer;

    /**
     * @param GetContainerRenderTags $getContainerRenderTags
     * @param RenderContainer        $renderContainer
     */
    public function __construct(
        GetContainerRenderTags $getContainerRenderTags,
        RenderContainer $renderContainer
    ) {
        $this->getContainerRenderTags = $getContainerRenderTags;
        $this->renderContainer = $renderContainer;
    }

    /**
     * @param Page|Content           $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $page,
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $pageTags = [];

        $containers = $page->getContainers();

        /**
         * @var string    $index
         * @var Container $container
         */
        foreach ($containers as $index => $container) {
            $renderTags = $this->getContainerRenderTags->__invoke(
                $container,
                $request
            );

            $pageTags[$container->ge] = $this->renderContainer->__invoke(
                $container,
                $renderTags
            );
        }

        return $pageTags;
    }
}
