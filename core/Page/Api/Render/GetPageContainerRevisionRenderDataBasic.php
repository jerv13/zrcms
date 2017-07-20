<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Page\Model\PageContainerRevision;
use Zrcms\Core\Page\Model\PageContainerRevisionProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRevisionRenderDataBasic implements GetPageContainerRevisionRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultGetPageContainerRevisionRenderDataServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultGetPageContainerRevisionRenderDataServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultGetPageContainerRevisionRenderDataServiceName = GetPageContainerRevisionRenderData::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultGetPageContainerRevisionRenderDataServiceName
            = $defaultGetPageContainerRevisionRenderDataServiceName;
    }

    /**
     * @param PageContainerRevision|ContentRevision $pageContainerRevision
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return array ['templateTag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        ContentRevision $pageContainerRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        // Get revision renderer or use default
        $getPageContainerRevisionRenderDataServiceName = $pageContainerRevision->getProperty(
            PageContainerRevisionProperties::RENDER_DATA_GETTER,
            $this->defaultGetPageContainerRevisionRenderDataServiceName
        );

        /** @var GetPageContainerRevisionRenderData $getPageContainerRevisionRenderDataService */
        $getPageContainerRevisionRenderDataService = $this->serviceContainer->get(
            $getPageContainerRevisionRenderDataServiceName
        );

        return $getPageContainerRevisionRenderDataService->__invoke(
            $pageContainerRevision,
            $request,
            $options
        );
    }
}
