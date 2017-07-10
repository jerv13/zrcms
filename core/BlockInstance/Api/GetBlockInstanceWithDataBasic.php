<?php

namespace Zrcms\Core\BlockInstance\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\Block\Model\DataProvider;
use Zrcms\Core\Block\Model\DataProviderNoop;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceData;
use Zrcms\Core\BlockInstance\Model\BlockInstanceDataBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstanceWithDataBasic implements GetBlockInstanceWithData
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
    protected $defaultDataProviderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlock          $findBlock
     * @param string             $defaultDataProviderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlock $findBlock,
        string $defaultDataProviderServiceName = DataProviderNoop::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findBlock = $findBlock;
        $this->defaultDataProviderServiceName = $defaultDataProviderServiceName;
    }

    /**
     * @param BlockInstance          $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return BlockInstanceData
     */
    public function __invoke(
        BlockInstance $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ): BlockInstanceData
    {
        $block = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        $dataProviderServiceName = $block->getProperty(
            BlockProperties::KEY_DATA_PROVIDER,
            $this->defaultDataProviderServiceName
        );

        /** @var DataProvider $dataProvider */
        $dataProvider = $this->serviceContainer->get(
            $dataProviderServiceName
        );

        $data = $dataProvider->__invoke(
            $blockInstance,
            $request
        );

        return new BlockInstanceDataBasic(
            $blockInstance->getUid(),
            $blockInstance->getUri(),
            $blockInstance->getBlockName(),
            $blockInstance->getConfig(),
            $blockInstance->getLayoutProperties(),
            $data,
            $blockInstance->getCreatedByUserId(),
            $blockInstance->getCreatedReason() . " Add data "
        );
    }
}
