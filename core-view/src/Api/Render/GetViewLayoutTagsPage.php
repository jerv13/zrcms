<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreApplication\Api\GetGuidV4;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Fields\FieldsContainerVersion;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CoreTheme\Model\Layout;
use Zrcms\CoreView\Api\GetContainerNamesByLayout;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsPage implements GetViewLayoutTags
{
    const RENDER_TAG_PAGE = 'page';
    const SERVICE_ALIAS = 'page';

    protected $getPageRenderTags;
    protected $getContainerNamesByLayout;
    protected $getContainerRenderTags;
    protected $renderContainer;

    /**
     * @param GetPageRenderTags         $getPageRenderTags
     * @param GetContainerNamesByLayout $getContainerNamesByLayout
     * @param GetContainerRenderTags    $getContainerRenderTags
     * @param RenderContainer           $renderContainer
     */
    public function __construct(
        GetPageRenderTags $getPageRenderTags,
        GetContainerNamesByLayout $getContainerNamesByLayout,
        GetContainerRenderTags $getContainerRenderTags,
        RenderContainer $renderContainer
    ) {
        $this->getPageRenderTags = $getPageRenderTags;
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
        /** @var PageVersion $page */
        $page = $view->getPageCmsResource()->getContentVersion();

        $pageRenderTags = $this->getPageRenderTags->__invoke(
            $page,
            $request
        );

        $pageRenderTags = $this->renderEmptyTags(
            $request,
            $pageRenderTags,
            $view->getLayoutCmsResource()->getContentVersion(),
            $view->getPageCmsResource()->getSiteCmsResourceId()
        );

        return [
            self::RENDER_TAG_PAGE => $pageRenderTags
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
                    FieldsContainerVersion::CONTEXT => PageVersion::CONTAINER_CONTEXT
                ],
                'render-temp-page-container',
                'render-temp-page-container'
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
