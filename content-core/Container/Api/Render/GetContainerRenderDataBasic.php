<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\Container\Model\ServiceAliasContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderDataBasic implements GetContainerRenderData
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var string
     */
    protected $defaultGetContainerRenderDataServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultGetContainerRenderDataServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultGetContainerRenderDataServiceName = GetContainerRenderDataBlocks::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasContainer::NAMESPACE_CONTENT_RENDERER;
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
        $getContainerRenderDataServiceAlias = $container->getProperty(
            PropertiesContainer::RENDER_DATA_GETTER,
            ''
        );

        /** @var GetContainerRenderData $getContainerRenderDataService */
        $getContainerRenderDataService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getContainerRenderDataServiceAlias,
            GetContainerRenderData::class,
            $this->defaultGetContainerRenderDataServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getContainerRenderDataService);

        return $getContainerRenderDataService->__invoke(
            $container,
            $request,
            $options
        );
    }
}
