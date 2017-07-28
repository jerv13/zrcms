<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\Theme\Model\Layout;
use Zrcms\ContentCore\Theme\Model\PropertiesLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindTagNamesByLayoutBasic implements FindTagNamesByLayout
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /***
     * @var string
     */
    protected $defaultFindTagNamesServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultFindTagNamesServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultFindTagNamesServiceName = FindTagNamesByLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
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
        $findTagNamesServiceName = $layout->getProperty(
            PropertiesLayout::RENDER_TAG_NAME_PARSER,
            $this->defaultFindTagNamesServiceName
        );

        /** @var FindTagNamesByLayout $findTagNamesService */
        $findTagNamesService = $this->serviceContainer->get(
            $findTagNamesServiceName
        );

        if (get_class($findTagNamesService) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        return $findTagNamesService->__invoke(
            $layout,
            $options
        );
    }
}
