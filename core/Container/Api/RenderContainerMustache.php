<?php

namespace Zrcms\Core\Container\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\BlockInstance\Api\FindBlockInstancesByContainer;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderContainerMustache implements RenderContainer
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindBlockInstancesByContainer
     */
    protected $findBlockInstancesByContainer;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlockInstancesByContainer $findBlockInstancesByContainer
     */
    public function __construct(
        $serviceContainer,
        FindBlockInstancesByContainer $findBlockInstancesByContainer
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findBlockInstancesByContainer = $findBlockInstancesByContainer;
    }

    /**
     * @param Container $container
     * @param array     $options
     *
     * @return string
     */
    public function __invoke(
        Container $container,
        array $options = []
    ): string
    {
        $blockInstances = $this->findBlockInstancesByContainer->__invoke(
            $container
        );

        $blockInstances
    }
}
