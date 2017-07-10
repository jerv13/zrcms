<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Uri\Api\BuildCmsUri;

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
     * @var FindContainers
     */
    protected $findContainers;

    /**
     * @var BuildCmsUri
     */
    protected $buildContainerUri;

    /**
     * @var RenderLayout
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param RenderLayout       $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        RenderLayout $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $options = []
    ):string
    {
        $renderServiceName = $layout->getProperty(
            LayoutProperties::KEY_RENDER,
            $this->defaultRenderServiceName
        );

        /** @var RenderLayout $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $layout,
            $page
        );
    }
}
