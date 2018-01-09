<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiUpsertCmsResource
{
    const SOURCE = 'zrcms-find-cms-resources-published';

    protected $upsertCmsResource;
    protected $cmsResourceToArray;
    protected $name;

    /**
     * @param UpsertCmsResource  $upsertCmsResource
     * @param CmsResourceToArray $cmsResourceToArray
     * @param string             $name
     */
    public function __construct(
        UpsertCmsResource $upsertCmsResource,
        CmsResourceToArray $cmsResourceToArray,
        string $name
    ) {
        $this->upsertCmsResource = $upsertCmsResource;
        $this->cmsResourceToArray = $cmsResourceToArray;
        $this->name = $name;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // @todo Write me
    }
}
