<?php

namespace Zrcms\Core\Page\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Layout\Api\Render\RenderLayout;
use Zrcms\Core\Page\Api\BuildPageUri;
use Zrcms\Core\Page\Api\FindPagePublished;
use Zrcms\Core\Site\Api\FindSitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageController
{
    protected $findSitePublished;

    protected $buildCmsUri;

    public function __construct(
        FindSitePublished $findSitePublished,
        FindPagePublished $findPagePublished,
        BuildPageUri $buildPageUri,
        BuildContainerUri $buildContainerUri,
        RenderLayout $renderLayout
    ) {
        $this->findSitePublished = $findSitePublished;
        $this->findPagePublished = $findPagePublished;
        $this->buildPageUri = $buildPageUri;
        $this->buildContainerUri = $buildContainerUri;
        $this->renderLayout = $renderLayout;
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
        $uri = $request->getUri();

        $site = $this->findSitePublished->__invoke(
            $uri->getHost()
        );

        if (empty($site)) {
            return $response->withStatus(404);
        }

//        $pageUri = $this->buildPageUri->__invoke(
//            $site->getId(),
//            $uri->getPath()
//        );

//        $page = $this->findPagePublished->__invoke($pageUri);
//
//        if (empty($page)) {
//            return $response->withStatus(404);
//        }
//
        // get page layout
        // get site layout in no page layout


        $this->renderLayout->__invoke(
            $layout
        );
    }
}
