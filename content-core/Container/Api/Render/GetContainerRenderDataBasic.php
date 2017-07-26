<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderDataBasic implements GetContainerRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultGetContainerRenderDataServiceName;

    /**
     * @param        $serviceContainer
     * @param string $defaultGetContainerRenderDataServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultGetContainerRenderDataServiceName = GetContainerRenderDataBlocks::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultGetContainerRenderDataServiceName = $defaultGetContainerRenderDataServiceName;
    }

    /**
     * @param Container|Content      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $getContainerRenderDataServiceName = $container->getProperty(
            PropertiesContainer::RENDER_DATA_GETTER,
            $this->defaultGetContainerRenderDataServiceName
        );

        /** @var GetContainerRenderData $getContainerRenderDataService */
        $getContainerRenderDataService = $this->serviceContainer->get(
            $getContainerRenderDataServiceName
        );

        if (get_class($getContainerRenderDataService) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        return $getContainerRenderDataService->__invoke(
            $container,
            $request,
            $options
        );
    }
}
