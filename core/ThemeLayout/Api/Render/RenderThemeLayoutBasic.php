<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\ThemeLayout;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderThemeLayoutBasic implements RenderThemeLayout
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
     * @param ThemeLayout|Content    $themeLayout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $themeLayout,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        $renderServiceName = $themeLayout->getProperty(
            ThemeLayoutProperties::RENDER,
            $this->defaultRenderServiceName
        );

        /** @var RenderContent $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $themeLayout,
            $request
        );
    }
}
