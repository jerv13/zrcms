<?php

namespace Zrcms\Core\Block\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRevisionDataNoop implements GetBlockRevisionData
{
    /**
     * @param BlockRevision          $blockRevision
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
        return [];
    }
}
