<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagBasic implements RenderHeadSectionTag
{
    const SERVICE_ALIAS = 'basic';

    protected $renderTag;
    protected $debug;

    /**
     * @param RenderTag $renderTag
     * @param bool      $debug
     */
    public function __construct(
        RenderTag $renderTag,
        bool $debug = false
    ) {
        $this->renderTag = $renderTag;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $sectionConfig
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string {
        $indent = Property::getString(
            $options,
            self::OPTION_INDENT,
            '    '
        );
        $lineBreak = Property::getString(
            $options,
            self::OPTION_LINE_BREAK,
            "\n"
        );

        $contentHtml = '';

        if ($this->debug) {
            $contentHtml .= $indent . '<!-- RenderHeadSectionTagDefault -->' . $lineBreak;
        }

        $tagContent = null;
        if (array_key_exists('__content', $sectionConfig)) {
            $tagContent = (string)$sectionConfig['__content'];
        }

        $attributes = $this->cleanConfig($sectionConfig);

        $contentHtml .= $indent . $this->renderTag->__invoke(
            [
                'tag' => $tag,
                'attributes' => $attributes,
                'content' => $tagContent
            ],
            $options
        );

        return $contentHtml;
    }

    /**
     * @param $sectionConfig
     *
     * @return mixed
     */
    protected function cleanConfig($sectionConfig)
    {
        foreach ($sectionConfig as $key => $attribute) {
            if (strpos($key, '__')) {
                unset($sectionConfig[$key]);
            }
        }

        return $sectionConfig;
    }
}
