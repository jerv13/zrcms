<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\View;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;
use Zrcms\ViewHead\Api\GetAvailableHeadSections;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagViewLayoutTags implements RenderHeadSectionTag
{
    const OPTION_VIEW = 'zrcms-view';

    protected $getServiceFromAlias;
    protected $serviceAliasNamespace;

    /**
     * @param GetServiceFromAlias      $getServiceFromAlias
     * @param string                   $serviceAliasNamespace
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        $serviceAliasNamespace = ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = $serviceAliasNamespace ;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $attributes
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     * @throws \Zrcms\ServiceAlias\Exception\ServiceSelfReferenceException
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $attributes,
        array $options = []
    ): string {
        // view-layout-tags-getter - Render from another tags getter
        if (!array_key_exists('__view-layout-tags-getter', $attributes)) {
            throw new CanNotRenderHeadSectionTag(
                'Does not have required key: (__view-layout-tags-getter)'
            );
        }

        /** @var View $view */
        $view = Param::getRequired(
            $options,
            self::OPTION_VIEW
        );

        $indent = Param::getString(
            $options,
            RenderTag::OPTION_INDENT,
            '    '
        );
        $lineBreak = Param::getString(
            $options,
            RenderTag::OPTION_LINE_BREAK,
            "\n"
        );

        /** @var GetViewLayoutTags $getViewLayoutTags */
        $getViewLayoutTags = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $attributes['__view-layout-tags-getter'],
            GetViewLayoutTags::class,
            ''
        );

        ServiceCheck::assertNotSelfReference($this, $getViewLayoutTags);

        $viewLayoutTags = $getViewLayoutTags->__invoke(
            $view,
            $request,
            $options
        );

        $html = '';

        foreach ($viewLayoutTags as $viewLayoutTagHtml) {
            $html .= $indent . $viewLayoutTagHtml . $lineBreak;
        }

        return $html;
    }
}
