<?php

namespace Zrcms\HttpRedirect\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpContentRedirect
{
    /**
     * @var GetSiteCmsResourceByRequest
     */
    protected $getSiteCmsResourceByRequest;

    /**
     * @var FindRedirectCmsResourceBySiteRequestPath
     */
    protected $findRedirectCmsResourceBySiteRequestPath;

    /**
     * @var int
     */
    protected $redirectStatus = 302;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param GetSiteCmsResourceByRequest              $getSiteCmsResourceByRequest
     * @param FindRedirectCmsResourceBySiteRequestPath $findRedirectCmsResourceBySiteRequestPath
     * @param int                                      $redirectStatus
     * @param array                                    $headers
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        FindRedirectCmsResourceBySiteRequestPath $findRedirectCmsResourceBySiteRequestPath,
        int $redirectStatus = 302,
        array $headers = []
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->findRedirectCmsResourceBySiteRequestPath = $findRedirectCmsResourceBySiteRequestPath;
        $this->redirectStatus = $redirectStatus;
        $this->headers = $headers;
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
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            return $next($request, $response);
        }

        $uri = $request->getUri();
        $requestPath = $uri->getPath();

        $redirectCmsResource = $this->findRedirectCmsResourceBySiteRequestPath->__invoke(
            $siteCmsResource->getId(),
            $requestPath
        );

        if (empty($redirectCmsResource)) {
            return $next($request, $response);
        }

        $redirectPath = $redirectCmsResource->getContentVersion()->getRedirectPath();

        if ($redirectPath == $requestPath) {
            throw new \Exception(
                'Redirect path (' . $redirectPath . ') '
                . 'can not be the same as request path (' . $requestPath . ')'
            );
        }

        return new RedirectResponse(
            $redirectCmsResource->getContentVersion()->getRedirectPath(),
            $this->redirectStatus,
            $this->headers
        );
    }
}
