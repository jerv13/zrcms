<?php

namespace Zrcms\HttpLocale\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\Locale\Api\SetLocale;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LocaleFromSite
{
    /**
     * @var SetLocale
     */
    protected $setLocale;

    /**
     * @var GetSiteCmsResourceByRequest
     */
    protected $getSiteCmsResourceByRequest;

    /**
     * @param SetLocale                   $setLocale
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     */
    public function __construct(
        SetLocale $setLocale,
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
    ) {
        $this->setLocale = $setLocale;
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
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
        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            $this->setLocale->__invoke(null);

            return $next($request, $response);
        }

        $this->setLocale->__invoke($siteCmsResource->getContentVersion()->getLocale());

        return $next($request, $response);
    }
}
