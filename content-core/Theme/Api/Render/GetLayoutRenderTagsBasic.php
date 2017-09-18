<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\ContentCore\Theme\Fields\FieldsLayout;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @deprecated NOT NEEDED?
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderTagsBasic implements GetLayoutRenderTags
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
    protected $defaultRenderTagsGetterServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultRenderTagsGetterServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultRenderTagsGetterServiceName = GetLayoutRenderTagsNoop::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasLayout::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->defaultRenderTagsGetterServiceName = $defaultRenderTagsGetterServiceName;
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
        $renderTagsGetterServiceAlias = $layout->getProperty(
            FieldsLayout::RENDER_TAGS_GETTER,
            ''
        );

        /** @var GetLayoutRenderTags $render */
        $renderTagsGetterService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderTagsGetterServiceAlias,
            GetLayoutRenderTags::class,
            $this->defaultRenderTagsGetterServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $renderTagsGetterService);

        return $renderTagsGetterService->__invoke(
            $layout,
            $request,
            $options
        );
    }
}
