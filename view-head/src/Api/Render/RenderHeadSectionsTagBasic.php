<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\View;
use Zrcms\ViewHead\Api\GetAvailableHeadSections;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBasic implements RenderHeadSectionsTag
{
    const OPTION_VIEW = 'zrcms-view';

    protected $getAvailableHeadSections;
    protected $renderHeadSectionTag;
    protected $debug;

    /**
     * @param GetAvailableHeadSections $getAvailableHeadSections
     * @param RenderHeadSectionTag     $renderHeadSectionTag
     * @param bool                     $debug
     */
    public function __construct(
        GetAvailableHeadSections $getAvailableHeadSections,
        RenderHeadSectionTag $renderHeadSectionTag,
        bool $debug = false
    ) {
        $this->getAvailableHeadSections = $getAvailableHeadSections;
        $this->renderHeadSectionTag = $renderHeadSectionTag;
        $this->debug = $debug;
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
        $orderedSections = $this->getAvailableHeadSections->__invoke();
        $html = '';

        if ($this->debug) {
            $debugHead = get_class($this);
            $html .= "<!-- ==== {$debugHead} ==== -->\n";
        }

        foreach ($orderedSections as $sectionName) {
            if ($this->debug) {
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
