<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSitePublishedFromRequest implements \Zrcms\Core\Site\Api\GetSitePublishedFromRequest
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
    ) {

    }
}
