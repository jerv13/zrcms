<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Reliv\ArrayProperties\Property;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagWithRenderService implements RenderHeadSectionTag
{
    const SERVICE_ALIAS = 'render-service';
    protected $serviceContainer;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param bool               $debug
     */
    public function __construct(
        $serviceContainer,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
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

        $renderServiceName = $sectionConfig['__render_service'];

        /** @var Render $renderService */
        $renderService = $this->serviceContainer->get($renderServiceName);

        $this->assertValidService($renderService);

        unset($sectionConfig['__render_service']);

        $renderedHtml = $renderService->__invoke(
            $request,
            $sectionConfig // NOTE: we push the config as the data or attributes
        );

        $contentHtml = '';

        if ($this->debug) {
            $contentHtml = $contentHtml . $indent
                . '<!-- RenderHeadSectionTagWithRenderer service:' . $renderServiceName . ' -->'
                . $lineBreak;
        }

        if (empty($renderedHtml)) {
            return $contentHtml;
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
