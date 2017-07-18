<?php

namespace Zrcms\Core\Theme\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\Theme\Model\LayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutBasic implements RenderLayout
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
        string $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        $renderServiceName = $layout->getProperty(
            LayoutProperties::RENDER,
            $this->defaultRenderServiceName
        );

        /** @var RenderContent $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $layout,
            $request
        );
    }
}
