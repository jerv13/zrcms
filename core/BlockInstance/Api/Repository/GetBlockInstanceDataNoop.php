<?php

namespace Zrcms\Core\BlockInstance\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockInstanceDataNoop implements GetBlockInstanceData
{
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
        return [];
    }
}
