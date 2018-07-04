<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Model\SiteContainerVersion;
use Zrcms\CoreTheme\Model\Layout;
use Zrcms\CoreView\Api\GetContainerNamesByLayout;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsContainers implements GetViewLayoutTags
{
    const RENDER_TAG_CONTAINER = 'container';
    const SERVICE_ALIAS = 'containers';

    protected $getContainerNamesByLayout;
    protected $getContainerRenderTags;
    protected $renderContainer;

    /**
     * @param GetContainerNamesByLayout $getContainerNamesByLayout
     * @param GetContainerRenderTags    $getContainerRenderTags
     * @param RenderContainer           $renderContainer
     */
    public function __construct(
        GetContainerNamesByLayout $getContainerNamesByLayout,
        GetContainerRenderTags $getContainerRenderTags,
        RenderContainer $renderContainer
    ) {
        $this->getContainerNamesByLayout = $getContainerNamesByLayout;
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

        $renderTags = $this->renderEmptyTags(
            $request,
            $renderTags,
            $view->getLayoutCmsResource()->getContentVersion(),
            $view->getPageCmsResource()->getSiteCmsResourceId()
        );

        return [
            self::RENDER_TAG_CONTAINER => $renderTags
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $renderTags
     * @param Layout                 $layout
     * @param string                 $siteCmsResourceId
     *
     * @return array
     */
    protected function renderEmptyTags(
        ServerRequestInterface $request,
        array $renderTags,
        Layout $layout,
        string $siteCmsResourceId
    ): array {
        $layoutTagNamesKeyed = array_flip(
            $this->getContainerNamesByLayout->__invoke(
                $layout
            )
        );

        foreach ($layoutTagNamesKeyed as $name => $index) {
            if (array_key_exists($name, $renderTags)) {
                // already rendered
                continue;
            }
            /** @var Container $container */
            $container = new ContainerVersionBasic(
                GetGuidV4::invoke(),
                [
                    FieldsContainerVersion::SITE_CMS_RESOURCE_ID => $siteCmsResourceId,
                    FieldsContainerVersion::NAME => $name,
                    FieldsContainerVersion::CONTEXT => SiteContainerVersion::CONTAINER_CONTEXT
                ],
                'render-temp-site-container',
                'render-temp-site-container'
            );

            $containerRenderTags = $this->getContainerRenderTags->__invoke(
                $container,
                $request
            );

            $renderTags[$name] = $this->renderContainer->__invoke(
                $container,
                $containerRenderTags
            );
        }

        return $renderTags;
    }
}
