<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\ContentCore\Theme\Model\PropertiesLayout;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindTagNamesByLayoutBasic implements FindTagNamesByLayout
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
        string $defaultFindTagNamesServiceName = FindTagNamesByLayoutMustache::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_LAYOUT_TAG_NAME_PARSER;
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
            PropertiesLayout::RENDER_TAG_NAME_PARSER,
            ''
        );

        /** @var FindTagNamesByLayout $findTagNamesService */
        $findTagNamesService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $findTagNamesServiceAlias,
            FindTagNamesByLayout::class,
            $this->defaultFindTagNamesServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $findTagNamesService);

        return $findTagNamesService->__invoke(
            $layout,
            $options
        );
    }
}
