<?php

namespace Zrcms\ContentCore\Block\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\ContentCore\Block\Exception\BlockComponentMissing;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockDataBasic implements GetBlockData
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
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @var string
     */
    protected $defaultGetBlockDataServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param FindComponent       $findComponent
     * @param string              $defaultGetBlockDataServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        FindComponent $findComponent,
        string $defaultGetBlockDataServiceName = GetBlockDataNoop::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasBlock::ZRCMS_CONTENT_DATA_PROVIDER;
        $this->findComponent = $findComponent;
        $this->defaultGetBlockDataServiceName = $defaultGetBlockDataServiceName;
    }

    /**
     * @param Block                  $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws BlockComponentMissing|\Exception
     */
    public function __invoke(
        Block $block,
        ServerRequestInterface $request,
        array $options = []
    ) : array {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findComponent->__invoke(
            'block',
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            // bockComponent my have been removed, so we return nothing
            return [];
        }

        $getBlockDataServiceAlias = $blockComponent->getProperty(
            FieldsBlockComponent::DATA_PROVIDER,
            ''
        );

        /** @var GetBlockData $getBlockData */
        $getBlockData = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getBlockDataServiceAlias,
            GetBlockData::class,
            $this->defaultGetBlockDataServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getBlockData);

        return $getBlockData->__invoke(
            $block,
            $request,
            $options
        );
    }
}
