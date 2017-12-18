<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Param\Param;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagDefault implements RenderHeadSectionTag
{
    protected $renderTag;
    protected $defaultDebug;

    /**
     * @param RenderTag $renderTag
     * @param bool      $defaultDebug
     */
    public function __construct(
        RenderTag $renderTag,
        bool $defaultDebug = true
    ) {
        $this->renderTag = $renderTag;
        $this->defaultDebug = $defaultDebug;
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
        // general - Render from a tag configuration
        $debug = Param::getBool(
            $options,
            self::OPTION_DEBUG,
            $this->defaultDebug
        );
        $indent = Param::getString(
            $options,
            self::OPTION_INDENT,
            '    '
        );
        $lineBreak = Param::getString(
            $options,
            self::OPTION_LINE_BREAK,
            "\n"
        );

        $contentHtml = '';

        if ($debug) {
            $contentHtml .= $indent . '<!-- RenderHeadSectionTagDefault -->' . $lineBreak;
        }

        $tagContent = null;
        if (array_key_exists('__content', $sectionConfig)) {
            $tagContent = (string)$sectionConfig['__content'];
        }

        $attributes = $this->cleanConfig($sectionConfig);

        $contentHtml .= $this->renderTag->__invoke(
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
