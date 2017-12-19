<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\Param\Param;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagWithRenderer implements RenderHeadSectionTag
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
        // __render_service - Render using a service with that is a Render
        if (!array_key_exists('__render_service', $sectionConfig)) {
            throw new CanNotRenderHeadSectionTag('Does not have required key: (__render_service)');
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

        $renderServiceName = $sectionConfig['__render_service'];

        /** @var object $renderService */
        $renderService = $this->serviceContainer->get($renderServiceName);

        $this->assertValidService($renderService);

        $renderedHtml = $renderService->__invoke(
            $request,
            $sectionConfig
        );

        if (empty($renderedHtml)) {
            return $renderedHtml;
        }

        $contentHtml = '';

        if ($debug) {
            $contentHtml = $contentHtml . $indent
                . '<!-- RenderHeadSectionTagWithRenderer service:' . $renderServiceName . ' -->'
                . $lineBreak;
        }

        $contentHtml .= $indent . $renderedHtml. $lineBreak;

        return $contentHtml;
    }

    /**
     * @param $renderService
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidService($renderService)
    {
        if (!is_a($renderService, Render::class)) {
            throw new \Exception(
                'Renderer must be instance of: ' . Render::class
            );
        }
    }
}
