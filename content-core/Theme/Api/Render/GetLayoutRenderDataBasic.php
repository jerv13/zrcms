<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\ContentCore\Theme\Model\PropertiesLayout;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataBasic implements GetLayoutRenderData
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
    protected $defaultRenderDataGetterServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultRenderDataGetterServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultRenderDataGetterServiceName = GetLayoutRenderDataNoop::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasLayout::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->defaultRenderDataGetterServiceName = $defaultRenderDataGetterServiceName;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderDataGetterServiceAlias = $layout->getProperty(
            PropertiesLayout::RENDER_TAGS_GETTER,
            ''
        );

        /** @var GetLayoutRenderData $render */
        $renderDataGetterService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderDataGetterServiceAlias,
            GetLayoutRenderData::class,
            $this->defaultRenderDataGetterServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $renderDataGetterService);

        return $renderDataGetterService->__invoke(
            $layout,
            $request,
            $options
        );
    }
}
