<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\Render\GetBlockRevisionRenderData;
use Zrcms\Core\Block\Api\Render\RenderBlockRevision;
use Zrcms\Core\Block\Api\Repository\FindBlockRevisionsBy;
use Zrcms\Core\Block\Api\WrapRenderedBlockRevision;
use Zrcms\Core\Block\Model\BlockRevision;
use Zrcms\Core\Block\Model\BlockRevisionProperties;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\ContainerRevision;
use Zrcms\Core\Container\Model\ContainerRevisionProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRevisionRenderDataBasic implements GetContainerRevisionRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultGetContainerRevisionRenderDataServiceName;

    /**
     * @param        $serviceContainer
     * @param string $defaultGetContainerRevisionRenderDataServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultGetContainerRevisionRenderDataServiceName = GetContainerRevisionRenderDataBlockRevisions::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultGetContainerRevisionRenderDataServiceName = $defaultGetContainerRevisionRenderDataServiceName;
    }

    /**
     * @param ContainerRevision|ContentRevision $containerRevision
     * @param ServerRequestInterface            $request
     * @param array                             $options
     *
     * @return array ['templateTag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        ContentRevision $containerRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $getContainerRevisionRenderDataServiceName = $containerRevision->getProperty(
            ContainerRevisionProperties::RENDER_DATA_GETTER,
            $this->defaultGetContainerRevisionRenderDataServiceName
        );

        /** @var GetContainerRevisionRenderData $getContainerRevisionRenderDataService */
        $getContainerRevisionRenderDataService = $this->serviceContainer->get(
            $getContainerRevisionRenderDataServiceName
        );

        return $getContainerRevisionRenderDataService->__invoke(
            $containerRevision,
            $request,
            $options
        );
    }
}
