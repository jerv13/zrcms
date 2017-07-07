<?php

namespace Zrcms\Core\Site\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSitePublishedFromRequest
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return SitePublished|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    );
}
