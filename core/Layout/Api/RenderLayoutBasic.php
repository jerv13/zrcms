<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Uri\Api\ParseCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutBasic extends RenderLayoutAbstract implements RenderLayout
{
    /**
     * @param ContainerInterface $serviceContainer
     * @param FindContainers     $findContainers
     * @param BuildContainerUri  $buildContainerUri
     * @param ParseCmsUri        $parseCmsUri
     * @param RenderLayout       $defaultRenderServiceName
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        FindContainers $findContainers,
        BuildContainerUri $buildContainerUri,
        ParseCmsUri $parseCmsUri,
        RenderLayout $defaultRenderServiceName
    ) {
        parent::__construct(
            $serviceContainer,
            $findContainers,
            $buildContainerUri,
            $parseCmsUri,
            $defaultRenderServiceName
        );
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
