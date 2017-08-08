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
    const RENDER_TAG_ALL = 'head-all';
    const SERVICE_ALIAS = 'head-all';

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
    protected $renderServiceAliases
        = [
            GetViewRenderTagsHeadMeta::RENDER_TAG_META => GetViewRenderTagsHeadMeta::SERVICE_ALIAS,
            GetViewRenderTagsHeadTitle::RENDER_TAG_TITLE => GetViewRenderTagsHeadTitle::SERVICE_ALIAS,
            GetViewRenderTagsHeadLink::RENDER_TAG_LINK => GetViewRenderTagsHeadLink::SERVICE_ALIAS,
            GetViewRenderTagsHeadScript::RENDER_TAG_SCRIPT => GetViewRenderTagsHeadScript::SERVICE_ALIAS,
        ];

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param array               $renderServiceAliases ['{tag-property-name}' => '{GetViewRenderTagsHeadServiceAlias}']
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        array $renderServiceAliases = []
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->renderServiceAliases = array_merge(
            $this->renderServiceAliases,
            $renderServiceAliases
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
        $renderTags = [];

        foreach ($this->renderServiceAliases as $renderTag => $renderServiceAlias) {
            /** @var GetViewRenderTagsHead $renderService */
            $renderService = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $renderServiceAlias,
                GetViewRenderTagsHead::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $renderService);

            $subRenderTags = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            $renderTags = array_merge(
                $renderTags,
                $subRenderTags
            );
        }

        $mergedHtml = '';

        foreach ($renderTags as $html) {
            $mergedHtml .= "\n" . $html;
        }

        return [
            self::RENDER_TAG_ALL => $mergedHtml
        ];
    }
}
