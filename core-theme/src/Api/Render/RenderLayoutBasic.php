<?php

namespace Zrcms\CoreTheme\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Fields\FieldsLayout;
use Zrcms\CoreTheme\Model\Layout;
use Zrcms\CoreTheme\Model\ServiceAliasLayout;
use Zrcms\ServiceAlias\Api\AssertNotSelfReference;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutBasic implements RenderLayout
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultRenderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasLayout::ZRCMS_CONTENT_RENDERER;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content $layout
     * @param array          $renderTags ['render-tag' => '{html}']
     * @param array          $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        array $renderTags,
        array $options = []
    ): string {
        $renderServiceAlias = $layout->findProperty(
            FieldsLayout::RENDERER,
            ''
        );

        /** @var RenderLayout $render */
        $render = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderServiceAlias,
            RenderLayout::class,
            $this->defaultRenderServiceName
        );

        AssertNotSelfReference::invoke($this, $render);

        return $render->__invoke(
            $layout,
            $renderTags,
            $options
        );
    }
}
