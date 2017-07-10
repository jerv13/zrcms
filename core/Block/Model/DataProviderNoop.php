<?php

namespace Zrcms\Core\Block\Model;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DataProviderNoop implements DataProvider
{
    /**
     * @param BlockInstance          $instance
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function __invoke(
        BlockInstance $instance,
        ServerRequestInterface $request
    ) : array
    {
        return [];
    }
}
