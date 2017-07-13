<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Container\ContainerInterface;
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
class RenderLayoutMustache implements RenderLayout
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
     * @param ContainerInterface $serviceContainer
     * @param FindContainers     $findContainers
     * @param BuildContainerUri  $buildContainerUri
     * @param ParseCmsUri        $parseCmsUri
     */
    public function __construct(
        $serviceContainer,
        FindContainers $findContainers,
        BuildContainerUri $buildContainerUri,
        ParseCmsUri $parseCmsUri
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainers = $findContainers;
        $this->buildContainerUri = $buildContainerUri;
        $this->parseCmsUri = $parseCmsUri;
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


        // @todo RENDER

        return '';
    }
}
