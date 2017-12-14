<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\View;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;
use Zrcms\ViewHead\Api\GetHeadSections;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBasic implements RenderHeadSectionsTag
{
    /**
     * @var RenderTag
     */
    protected $renderTag;

    /**
     * @var GetHeadSections
     */
    protected $getHeadSections;

    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @param RenderTag           $renderTag
     * @param GetHeadSections     $getHeadSections
     * @param GetServiceFromAlias $getServiceFromAlias
     */
    public function __construct(
        RenderTag $renderTag,
        GetHeadSections $getHeadSections,
        GetServiceFromAlias $getServiceFromAlias
    ) {
        $this->renderTag = $renderTag;
        $this->getHeadSections = $getHeadSections;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER;
    }

    /**
     * @param View                   $view
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param array                  $sections
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        View $view,
        ServerRequestInterface $request,
        string $tag,
        array $sections,
        array $options = []
    ): string {
        $debug = Param::getBool($options, 'debug', true);
        $orderedSections = $this->getHeadSections->__invoke();
        $html = '';

        if ($debug) {
            $debugHead = get_class($this);
            $html .= "<!-- ==== {$debugHead} ==== -->\n";
        }

        foreach ($orderedSections as $sectionName) {
            if ($debug) {
                $debugSectionName = strtoupper($sectionName);
                $html .= "    <!-- *** {$debugSectionName} *** -->\n";
            }
            if (!array_key_exists($sectionName, $sections)) {
                continue;
            }
            $html .= $this->renderSection($view, $request, $tag, $sections[$sectionName]);
        }

        return $html;
    }

    /**
     * @param View                   $view
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param array                  $section
     * @param array                  $options
     *
     * @return string
     */
    protected function renderSection(
        View $view,
        ServerRequestInterface $request,
        string $tag,
        array $section,
        array $options = []
    ): string {
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

        $html = '';
        /**
         * @var string       $name
         * @var array|string $attributes
         */
        foreach ($section as $name => $attributes) {
            // literal - Render a string as it is in the config
            if (array_key_exists('__literal', $attributes)) {
                $html .= $indent . (string)$attributes['__literal'] . $lineBreak;
                continue;
            }

            // view-layout-tags-getter - Render from another tags getter
            if (array_key_exists('__view-layout-tags-getter', $attributes)) {

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

                foreach ($viewLayoutTags as $viewLayoutTagHtml) {
                    $html .= $indent . $viewLayoutTagHtml . $lineBreak;
                }

                continue;
            }

            // general - Render from a tag configuration
            $contentHtml = null;
            if (array_key_exists('__content', $attributes)) {
                $contentHtml = (string)$attributes['__content'];
            }

            $attributes = $this->cleanAttributes($attributes);

            $html .= $this->renderTag->__invoke(
                [
                    'tag' => $tag,
                    'attributes' => $attributes,
                    'content' => $contentHtml
                ],
                [RenderTag::OPTION_INDENT => $indent]
            );
        }

        return $html;
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    protected function cleanAttributes($attributes)
    {

        foreach ($attributes as $key => $attribute) {
            if (strpos($key, '__')) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }
}
