<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistory
{
    protected $findCmsResourceHistory;
    protected $cmsResourceHistoryToArray;
    protected $name;

    /**
     * @param FindCmsResourceHistory    $findCmsResourceHistory
     * @param CmsResourceHistoryToArray $cmsResourceHistoryToArray
     * @param string                    $name
     */
    public function __construct(
        FindCmsResourceHistory $findCmsResourceHistory,
        CmsResourceHistoryToArray $cmsResourceHistoryToArray,
        string $name
    ) {
        $this->findCmsResourceHistory = $findCmsResourceHistory;
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
