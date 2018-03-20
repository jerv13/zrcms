<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsContainers implements GetViewLayoutTags
{
    const RENDER_TAG_CONTAINER = 'container';
    const SERVICE_ALIAS = 'containers';

    protected $getContainerRenderTags;
    protected $renderContainer;

    /**
     * @param GetContainerRenderTags               $getContainerRenderTags
     * @param RenderContainer                      $renderContainer
     */
    public function __construct(
        GetContainerRenderTags $getContainerRenderTags,
        RenderContainer $renderContainer
    ) {
        $this->getContainerRenderTags = $getContainerRenderTags;
        $this->renderContainer = $renderContainer;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $containerCmsResources = $view->getSiteContainerCmsResources();

        $renderTags = [];

        /** @var ContainerCmsResource $containerCmsResource */
        foreach ($containerCmsResources as $containerCmsResource) {
            /** @var Container $container */
            $container = $containerCmsResource->getContentVersion();

            $containerRenderTags = $this->getContainerRenderTags->__invoke(
                $container,
                $request
            );

            $renderTags[$containerCmsResource->getName()] = $this->renderContainer->__invoke(
                $container,
                $containerRenderTags
            );
        }

        return [
            self::RENDER_TAG_CONTAINER => $renderTags
        ];
    }
}
