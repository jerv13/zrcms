<?php

namespace Rcms\Core\Site\Api;

use Psr\Http\Message\ServerRequestInterface;
use Rcms\Core\Site\Model\Site;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSiteFromRequest
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return Site|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    );
}
