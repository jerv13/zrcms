<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\PropertiesBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockDataBasic implements GetBlockData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindBlockComponent
     */
    protected $findBlockComponent;

    /**
     * @var string
     */
    protected $defaultGetBlockDataServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlockComponent $findBlockComponent
     * @param string             $defaultGetBlockDataServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlockComponent $findBlockComponent,
        string $defaultGetBlockDataServiceName = GetBlockDataNoop::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findBlockComponent = $findBlockComponent;
        $this->defaultGetBlockDataServiceName = $defaultGetBlockDataServiceName;
    }

    /**
     * @param Block                  $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Block $block,
        ServerRequestInterface $request,
        array $options = []
    ) : array
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        $getBlockDataServiceName = $blockComponent->getProperty(
            PropertiesBlockComponent::DATA_PROVIDER,
            $this->defaultGetBlockDataServiceName
        );

        /** @var GetBlockData $getBlockData */
        $getBlockData = $this->serviceContainer->get(
            $getBlockDataServiceName
        );

        if (get_class($getBlockData) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        return $getBlockData->__invoke(
            $block,
            $request,
            $options
        );
    }
}
