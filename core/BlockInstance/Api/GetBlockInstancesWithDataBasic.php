<?php

namespace Zrcms\Core\BlockInstance\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstancesWithDataBasic implements GetBlockInstancesWithData
{
    /**
     * @var GetBlockInstanceWithData
     */
    protected $getBlockInstanceWithData;

    /**
     * @param GetBlockInstanceWithData $getBlockInstanceWithData
     */
    public function __construct(
        GetBlockInstanceWithData $getBlockInstanceWithData
    ) {
        $this->getBlockInstanceWithData = $getBlockInstanceWithData;
    }

    /**
     * @param array                  $blockInstances [BlockInstance]
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array [BlockInstanceData]
     */
    public function __invoke(
        array $blockInstances,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        /** @var BlockInstance $blockInstance */
        foreach ($blockInstances as $key => $blockInstance) {
            $blockInstances[$key] = $this->getBlockInstanceWithData->__invoke(
                $blockInstance,
                $request
            );
        }

        return $blockInstances;
    }
}
