<?php

namespace Zrcms\Core\BlockInstance\Api\Repository;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstanceDataBasic implements GetBlockInstanceData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindBlock
     */
    protected $findBlock;

    /**
     * @var string
     */
    protected $defaultGetBlockInstanceDataServiceName;

    /**
     * @param ContainerInterface           $serviceContainer
     * @param FindBlock $findBlock
     * @param string    $defaultGetBlockInstanceDataServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlock $findBlock,
        string $defaultGetBlockInstanceDataServiceName = GetBlockInstanceDataNoop::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findBlock = $findBlock;
        $this->defaultGetBlockInstanceDataServiceName = $defaultGetBlockInstanceDataServiceName;
    }

    /**
     * @param BlockInstance          $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        BlockInstance $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ) : array
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        $defaultGetBlockInstanceDataServiceName = $block->getProperty(
            BlockProperties::DATA_PROVIDER,
            $this->defaultGetBlockInstanceDataServiceName
        );

        /** @var GetBlockInstanceData $getBlockInstanceData */
        $getBlockInstanceData = $this->serviceContainer->get(
            $defaultGetBlockInstanceDataServiceName
        );

        return $getBlockInstanceData->__invoke(
            $blockInstance,
            $request,
            $options
        );
    }
}
