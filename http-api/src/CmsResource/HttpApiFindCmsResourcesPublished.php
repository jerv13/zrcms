<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\FindCmsResourcesPublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourcesPublished
{
    const SOURCE = 'zrcms-find-cms-resources-published';

    protected $findCmsResourcesPublished;
    protected $cmsResourceToArray;
    protected $name;

    /**
     * @param FindCmsResourcesPublished $findCmsResourcesPublished
     * @param CmsResourceToArray        $cmsResourceToArray
     * @param string                    $name
     */
    public function __construct(
        FindCmsResourcesPublished $findCmsResourcesPublished,
        CmsResourceToArray $cmsResourceToArray,
        string $name
    ) {
        $this->findCmsResourcesPublished = $findCmsResourcesPublished;
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
