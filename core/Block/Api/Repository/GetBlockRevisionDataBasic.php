<?php

namespace Zrcms\Core\Block\Api\Repository;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Block\Model\BlockComponent;
use Zrcms\Core\Block\Model\BlockComponentProperties;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRevisionDataBasic implements GetBlockRevisionData
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
    protected $defaultGetBlockRevisionDataServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlockComponent $findBlockComponent
     * @param string             $defaultGetBlockRevisionDataServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlockComponent $findBlockComponent,
        string $defaultGetBlockRevisionDataServiceName = GetBlockRevisionDataNoop::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findBlockComponent = $findBlockComponent;
        $this->defaultGetBlockRevisionDataServiceName = $defaultGetBlockRevisionDataServiceName;
    }

    /**
     * @param BlockRevision  $blockRevision
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        BlockRevision $blockRevision,
        ServerRequestInterface $request,
        array $options = []
    ) : array
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $blockRevision->getBlockComponentName()
        );

        $getBlockRevisionDataServiceName = $blockComponent->getProperty(
            BlockComponentProperties::DATA_PROVIDER,
            $this->defaultGetBlockRevisionDataServiceName
        );

        /** @var GetBlockRevisionData $getBlockRevisionData */
        $getBlockRevisionData = $this->serviceContainer->get(
            $getBlockRevisionDataServiceName
        );

        return $getBlockRevisionData->__invoke(
            $blockRevision,
            $request,
            $options
        );
    }
}
