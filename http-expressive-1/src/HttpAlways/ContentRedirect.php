<?php

namespace Zrcms\HttpExpressive1\HttpAlways;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceVersionByRequest;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceVersionBySiteRequestPath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentRedirect
{
    /**
     * @var GetSiteCmsResourceVersionByRequest
     */
    protected $getSiteCmsResourceVersionByRequest;

    /**
     * @var FindRedirectCmsResourceVersionBySiteRequestPath
     */
    protected $findRedirectCmsResourceVersionBySiteRequestPath;

    /**
     * @var int
     */
    protected $redirectStatus = 302;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param GetSiteCmsResourceVersionByRequest              $getSiteCmsResourceVersionByRequest
     * @param FindRedirectCmsResourceVersionBySiteRequestPath $findRedirectCmsResourceVersionBySiteRequestPath
     * @param int                                             $redirectStatus
     * @param array                                           $headers
     */
    public function __construct(
        GetSiteCmsResourceVersionByRequest $getSiteCmsResourceVersionByRequest,
        FindRedirectCmsResourceVersionBySiteRequestPath $findRedirectCmsResourceVersionBySiteRequestPath,
        int $redirectStatus = 302,
        array $headers = []
    ) {
        $this->getSiteCmsResourceVersionByRequest = $getSiteCmsResourceVersionByRequest;
        $this->findRedirectCmsResourceVersionBySiteRequestPath = $findRedirectCmsResourceVersionBySiteRequestPath;
        $this->redirectStatus = $redirectStatus;
        $this->headers = $headers;
    }

    /**
     * __invoke
     *
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
        $siteCmsResourceVersion = $this->getSiteCmsResourceVersionByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResourceVersion)) {
            return $next($request, $response);
        }

        $uri = $request->getUri();

        $redirect = $this->findRedirectCmsResourceVersionBySiteRequestPath->__invoke(
            $siteCmsResourceVersion->getCmsResourceId(),
            $uri->getPath()
        );

        if (empty($redirect)) {
            return $next($request, $response);
        }

        $uri = $uri->withPath(
            $redirect->getVersion()->getRedirectPath()
        );

        return new RedirectResponse(
            $uri,
            $this->redirectStatus,
            $this->headers
        );
    }
}
