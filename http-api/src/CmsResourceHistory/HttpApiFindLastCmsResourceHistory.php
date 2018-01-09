<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindLastCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindLastCmsResourceHistory
{
    protected $findLastCmsResourceHistory;
    protected $cmsResourceHistoryToArray;
    protected $name;

    /**
     * @param FindLastCmsResourceHistory $findLastCmsResourceHistory
     * @param CmsResourceHistoryToArray  $cmsResourceHistoryToArray
     * @param string                     $name
     */
    public function __construct(
        FindLastCmsResourceHistory $findLastCmsResourceHistory,
        CmsResourceHistoryToArray $cmsResourceHistoryToArray,
        string $name
    ) {
        $this->findLastCmsResourceHistory = $findLastCmsResourceHistory;
        $this->cmsResourceHistoryToArray = $cmsResourceHistoryToArray;
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
