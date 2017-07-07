<?php

namespace Zrcms\Core\Page\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Api\GetContainerUri;
use Zrcms\Core\Container\Api\RenderPage;
use Zrcms\Core\Page\Api\FindPagePublished;
use Zrcms\Core\Page\Api\GetPageUri;
use Zrcms\Core\Site\Api\GetSitePublishedFromRequest;
use Zrcms\Core\Uri\Api\BuildCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageController
{
    protected $getSitePublishedFromRequest;

    protected $buildCmsUri;

    public function __construct(
        GetSitePublishedFromRequest $getSitePublishedFromRequest,
        FindPagePublished $findPagePublished,
        GetPageUri $getPageUri,
        GetContainerUri $getContainerUri
    ) {
        $this->getSitePublishedFromRequest = $getSitePublishedFromRequest;
        $this->findPagePublished = $findPagePublished;
        $this->getPageUri = $getPageUri;
        $this->getContainerUri = $getContainerUri;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $site = $this->getSitePublishedFromRequest->__invoke(
            $request
        );

        if (empty($site)) {
            return $response->withStatus(404);
        }

        $path = $request->getUri()->getPath();

        $pageUri = $this->getPageUri->__invoke(
            $site->getId(),
            $path
        );

        $page = $this->findPagePublished->__invoke($pageUri);

        if (empty($page)) {
            return $response->withStatus(404);
        }


    }
}
