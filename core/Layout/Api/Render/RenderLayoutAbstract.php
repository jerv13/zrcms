<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Container\Api\RenderContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Uri\Api\BuildCmsUri;
use Zrcms\Core\Uri\Api\ParseCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RenderLayoutAbstract implements RenderLayout
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
     * @var ParseCmsUri
     */
    protected $parseCmsUri;

    /**
     * @var RenderLayout
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindContainers     $findContainers
     * @param BuildContainerUri  $buildContainerUri
     * @param ParseCmsUri        $parseCmsUri
     * @param RenderLayout       $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindContainers $findContainers,
        BuildContainerUri $buildContainerUri,
        ParseCmsUri $parseCmsUri,
        RenderLayout $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainers = $findContainers;
        $this->buildContainerUri = $buildContainerUri;
        $this->parseCmsUri = $parseCmsUri;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content $content
     * @param array   $renderData
     * @param array   $options
     *
     * @return string
     */
    public function __invoke(
        Content $content,
        array $renderData,
        array $options = []
    ): string
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

    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return array
     */
    protected function getData(
        Layout $layout,
        Page $page,
        array $options = []
    ): array
    {

    }
}
