<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryBy
{
    protected $findCmsResourceHistoryBy;
    protected $cmsResourceHistoryToArray;
    protected $name;

    /**
     * @param FindCmsResourceHistoryBy  $findCmsResourceHistoryBy
     * @param CmsResourceHistoryToArray $cmsResourceHistoryToArray
     * @param string                    $name
     */
    public function __construct(
        FindCmsResourceHistoryBy $findCmsResourceHistoryBy,
        CmsResourceHistoryToArray $cmsResourceHistoryToArray,
        string $name
    ) {
        $this->findCmsResourceHistoryBy = $findCmsResourceHistoryBy;
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
