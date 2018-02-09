<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagFileIncludes implements RenderHeadSectionTag
{
    const SERVICE_ALIAS = 'file-includes';

    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct(
        bool $debug = false
    ) {
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
     * @throws CanNotRenderHeadSectionTag
     * @throws \Exception
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

        foreach ($sectionConfig['__file-includes'] as $source => $filePath) {
            if ($this->debug) {
                $contentHtml .= $indent
                    . '<!-- RenderHeadSectionTagFileIncludes source: ' . $source . ' file: ' . $filePath . '-->'
                    . $lineBreak;
            }

            $contentHtml .= $indent . $this->readFile(
                $filePath
            ) . $lineBreak;
        }

        return $contentHtml;
    }

    /**
     * @param string $filePath
     *
     * @return string
     * @throws \Exception
     */
    public function readFile(
        string $filePath
    ): string {
        $realFilePath = realpath($filePath);

        if (empty($realFilePath)) {
            throw new \Exception('Path is not valid: ' . $filePath);
        }

        if (!is_file($realFilePath)) {
            throw new \Exception('File path must be a file: ' . $filePath);
        }

        return file_get_contents($realFilePath);
    }
}
