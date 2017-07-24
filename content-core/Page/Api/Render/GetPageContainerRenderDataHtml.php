<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PropertiesPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderDataHtml implements GetPageContainerRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultGetPageContainerRenderDataServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultGetPageContainerRenderDataServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultGetPageContainerRenderDataServiceName = GetPageContainerRenderData::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultGetPageContainerRenderDataServiceName
            = $defaultGetPageContainerRenderDataServiceName;
    }

    /**
     * @param Page|Content  $pageContainer
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderedData = [];

        $renderedData[] = $pageContainer->getProperty(
            PropertiesPage::PRE_RENDERED_HTML
        );

        return $renderedData;
    }
}
