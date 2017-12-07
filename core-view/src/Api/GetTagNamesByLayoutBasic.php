<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\Layout;
use Zrcms\CoreTheme\Fields\FieldsLayout;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTagNamesByLayoutBasic implements GetTagNamesByLayout
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /***
     * @var string
     */
    protected $defaultFindTagNamesServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultFindTagNamesServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultFindTagNamesServiceName = GetTagNamesByLayoutMustache::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER;
        $this->defaultFindTagNamesServiceName = $defaultFindTagNamesServiceName;
    }

    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-path}']
     * @throws \Exception
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array
    {
        $findTagNamesServiceAlias = $layout->getDefaultIfEmptyProperty(
            FieldsLayout::RENDER_TAG_NAME_PARSER,
            ''
        );

        /** @var GetTagNamesByLayout $findTagNamesService */
        $findTagNamesService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $findTagNamesServiceAlias,
            GetTagNamesByLayout::class,
            $this->defaultFindTagNamesServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $findTagNamesService);

        return $findTagNamesService->__invoke(
            $layout,
            $options
        );
    }
}
