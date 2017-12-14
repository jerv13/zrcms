<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\View;
use Zrcms\Param\Param;
use Zrcms\ViewHead\Api\GetAvailableHeadSections;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBasic implements RenderHeadSectionsTag
{
    const OPTION_VIEW = 'zrcms-view';

    protected $getAvailableHeadSections;
    protected $renderHeadSectionTag;

    /**
     * @param GetAvailableHeadSections $getAvailableHeadSections
     * @param RenderHeadSectionTag     $renderHeadSectionTag
     */
    public function __construct(
        GetAvailableHeadSections $getAvailableHeadSections,
        RenderHeadSectionTag $renderHeadSectionTag
    ) {
        $this->getAvailableHeadSections = $getAvailableHeadSections;
        $this->renderHeadSectionTag = $renderHeadSectionTag;
    }

    /**
     * @param View                   $view
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param array                  $sections
     * @param array                  $options
     *
     * @return string
     * @throws \Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag
     */
    public function __invoke(
        View $view,
        ServerRequestInterface $request,
        string $tag,
        array $sections,
        array $options = []
    ): string {
        $debug = Param::getBool($options, 'debug', true);
        $orderedSections = $this->getAvailableHeadSections->__invoke();
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
                // @todo Should throw?
                continue;
            }
            $html .= $this->renderSectionTags($view, $request, $tag, $sections[$sectionName], $options);
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
     * @throws \Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag
     */
    protected function renderSectionTags(
        View $view,
        ServerRequestInterface $request,
        string $tag,
        array $section,
        array $options = []
    ): string {
        $options[self::OPTION_VIEW] = $view;

        $html = '';
        /**
         * @var string       $sectionName
         * @var array|string $attributes
         */
        foreach ($section as $sectionEntryName => $attributes) {
            $html .= $this->renderHeadSectionTag->__invoke(
                $request,
                $tag,
                $sectionEntryName,
                $attributes,
                $options
            );
        }

        return $html;
    }
}
