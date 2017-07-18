<?php

namespace Zrcms\Core\Theme\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\Theme\Model\LayoutCmsResource;
use Zrcms\Core\Theme\Model\LayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutCmsResourceBasic implements RenderLayoutCmsResource
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderServiceName = RenderLayoutCmsResourceMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param array                         $renderData ['templateTag' => '{html}']
     * @param array                         $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        array $renderData,
        array $options = []
    ): string
    {
        $layout = $layoutCmsResource->getContent();

        $renderServiceName = $layout->getProperty(
            LayoutProperties::RENDER,
            $this->defaultRenderServiceName
        );

        /** @var RenderCmsResource $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $layoutCmsResource,
            $renderData
        );
    }
}
