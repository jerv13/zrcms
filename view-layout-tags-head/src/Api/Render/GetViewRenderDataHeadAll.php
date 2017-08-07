<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderTagsHeadAll implements GetViewRenderTagsHead
{
    const RENDER_TAG_ALL = 'all';

    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var array
     */
    protected $renderServiceNames
        = [
            GetViewRenderTagsHeadMeta::RENDER_TAG_META => GetViewRenderTagsHeadMeta::class,
            GetViewRenderTagsHeadTitle::RENDER_TAG_TITLE => GetViewRenderTagsHeadTitle::class,
            GetViewRenderTagsHeadLink::RENDER_TAG_LINK => GetViewRenderTagsHeadLink::class,
            GetViewRenderTagsHeadScript::RENDER_TAG_SCRIPT => GetViewRenderTagsHeadScript::class,
        ];

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param array               $renderServiceNames ['{tag-property-name}' => '{GetViewRenderTagsHeadServiceAlias}']
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        array $renderServiceNames = []
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->renderServiceNames = array_merge(
            $this->renderServiceNames,
            $renderServiceNames
        );
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderData = [];

        foreach ($this->renderServiceNames as $renderTag => $renderServiceAlias) {
            /** @var GetViewRenderTagsHead $renderService */
            $renderService = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $renderServiceAlias,
                GetViewRenderTagsHead::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $renderService);

            $subRenderData = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            if (!is_array($subRenderData[GetViewRenderTagsHead::RENDER_TAG])) {
                throw new \Exception(
                    get_class($this) . ' requires injected services to return array with '
                    . GetViewRenderTagsHead::RENDER_TAG . ' as a key'
                );
            }

            $renderData = array_merge(
                $renderData,
                $subRenderData[GetViewRenderTagsHead::RENDER_TAG]
            );
        }

        $mergedHtml = '';

        foreach ($renderData as $html) {
            $mergedHtml .= "\n" . $html;
        }

        return [
            GetViewRenderTagsHead::RENDER_TAG => [
                self::RENDER_TAG_ALL => $mergedHtml
            ],
        ];
    }
}
