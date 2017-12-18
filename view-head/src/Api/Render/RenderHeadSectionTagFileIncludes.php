<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\File\Api\ReadFile;
use Zrcms\File\Exception\CanNotReadFile;
use Zrcms\Param\Param;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagFileIncludes implements RenderHeadSectionTag
{
    protected $readFile;
    protected $defaultDebug;

    /**
     * @param ReadFile $readFile
     * @param bool     $defaultDebug
     */
    public function __construct(
        ReadFile $readFile,
        bool $defaultDebug = true
    ) {
        $this->readFile = $readFile;
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
     * @throws CanNotRenderHeadSectionTag
     * @throws CanNotReadFile
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string {
        // __file-includes - Render file contents
        if (!array_key_exists('__file-includes', $sectionConfig)) {
            throw new CanNotRenderHeadSectionTag('Does not have required key: (__file-includes)');
        }
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

        foreach ($sectionConfig['__file-includes'] as $source => $filePathUri) {
            if ($debug) {
                $contentHtml .= $indent
                    . '<!-- RenderHeadSectionTagFileIncludes source: ' . $source . ' file: ' . $filePathUri . '-->'
                    . $lineBreak;
            }

            $contentHtml .= $indent . $this->readFile->__invoke(
                    $request,
                    $filePathUri
                ) . $lineBreak;
        }

        return $contentHtml;
    }
}
