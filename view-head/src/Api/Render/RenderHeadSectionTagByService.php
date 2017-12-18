<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Param\Param;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagByService implements RenderHeadSectionTag
{
    protected $serviceContainer;
    protected $defaultDebug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param bool               $defaultDebug
     */
    public function __construct(
        $serviceContainer,
        bool $defaultDebug = true
    ) {
        $this->serviceContainer = $serviceContainer;
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
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string {
        // render_head_section_tag - Render using a service of type RenderHeadSectionTag
        if (!array_key_exists('__render_head_section_tag', $sectionConfig)) {
            throw new CanNotRenderHeadSectionTag('Does not have required key: (__render_head_section_tag)');
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

        $renderHeadSectionTagServiceName = $sectionConfig['__render_head_section_tag'];

        /** @var RenderHeadSectionTag $renderHeadSectionTag */
        $renderHeadSectionTag = $this->serviceContainer->get($renderHeadSectionTagServiceName);

        $this->assertValidService($renderHeadSectionTag);

        $contentHtml = $renderHeadSectionTag->__invoke(
            $request,
            $tag,
            $sectionEntryName,
            $sectionConfig,
            $options = []
        );

        if (empty($contentHtml)) {
            return $contentHtml;
        }

        if ($debug) {
            $contentHtml = $contentHtml . $indent
                . '<!-- RenderHeadSectionTagByService service:' . $renderHeadSectionTagServiceName . ' -->'
                . $lineBreak;
        }

        $contentHtml .= $indent . (string)$sectionConfig['__literal'] . $lineBreak;

        return $contentHtml;
    }

    /**
     * @param $renderHeadSectionTag
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidService($renderHeadSectionTag)
    {
        if (!is_a($renderHeadSectionTag, RenderHeadSectionTag::class)) {
            throw new \Exception(
                'RenderHeadSectionTag must be instance of: ' . RenderHeadSectionTag::class
            );
        }
    }
}
