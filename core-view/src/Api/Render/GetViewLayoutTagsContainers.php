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

            $renderTags[$containerCmsResource->getPath()] = $this->renderContainer->__invoke(
                $container,
                $containerRenderTags
            );
        }

        return [
            self::RENDER_TAG_CONTAINER => $renderTags
        ];
    }

    /**
     * @param array $layoutTags
     *
     * @return array
     */
    protected function findContainerPaths(
        array $layoutTags
    ) {
        $paths = [];
        foreach ($layoutTags as $layoutTag) {
            $path = $this->getPath($layoutTag);
            if ($path !== null) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    /**
     * @todo NOTE: this will only work with tags like container.{path}
     * @todo Not with container.something.{path}
     *
     * @param string $layoutTag
     *
     * @return bool
     */
    protected function getPath(string $layoutTag)
    {
        $hasTag = (0 === strpos($layoutTag, self::RENDER_TAG_CONTAINER));

        if (!$hasTag) {
            return null;
        }

        $parts = explode('.', $layoutTag);

        if (count($parts) !== 2) {
            // @todo error??
            return null;
        }

        return $parts[1];
    }
}
