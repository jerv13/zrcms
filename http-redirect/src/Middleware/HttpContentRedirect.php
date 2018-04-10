<?php

namespace Zrcms\HttpRedirect\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpContentRedirect implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|RedirectResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            return $delegate->process($request);
        }

        $uri = $request->getUri();
        $requestPath = $uri->getPath();

        $redirectCmsResource = $this->findRedirectCmsResourceBySiteRequestPath->__invoke(
            $siteCmsResource->getId(),
            $requestPath
        );

        if (empty($redirectCmsResource)) {
            return $delegate->process($request);
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
