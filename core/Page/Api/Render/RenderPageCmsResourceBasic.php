<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Container\Api\Render\RenderContainerCmsResourceBasic;
use Zrcms\Core\Page\Model\PageCmsResource;
use Zrcms\Core\Page\Model\PageProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageCmsResourceBasic implements RenderPageCmsResource
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderPageCmsResourceServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string $defaultRenderPageCmsResourceServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderPageCmsResourceServiceName = RenderContainerCmsResourceBasic::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderPageCmsResourceServiceName = $defaultRenderPageCmsResourceServiceName;
    }

    /**
     * @param PageCmsResource|CmsResource $pageCmsResource
     * @param array                       $renderData ['[page]' => '{html}']
     * @param array                       $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $pageCmsResource,
        array $renderData,
        array $options = []
    ): string
    {
        $page = $pageCmsResource->getContent();

        $renderPageCmsResourceServiceName = $page->getProperty(
            PageProperties::RENDER,
            $this->defaultRenderPageCmsResourceServiceName
        );

        /** @var RenderPageCmsResource $renderPageCmsResourceService */
        $renderPageCmsResourceService = $this->serviceContainer->get(
            $renderPageCmsResourceServiceName
        );

        return $renderPageCmsResourceService->__invoke(
            $pageCmsResource,
            $renderData
        );
    }
}
