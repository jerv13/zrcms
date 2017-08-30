<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceVersionByRequest;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceVersion;
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
     * @var GetSiteCmsResourceVersionByRequest
     */
    protected $getSiteCmsResourceVersionByRequest;

    /**
     * @param SetLocale                          $setLocale
     * @param GetSiteCmsResourceVersionByRequest $getSiteCmsResourceVersionByRequest
     */
    public function __construct(
        SetLocale $setLocale,
        GetSiteCmsResourceVersionByRequest $getSiteCmsResourceVersionByRequest
    ) {
        $this->setLocale = $setLocale;
        $this->getSiteCmsResourceVersionByRequest = $getSiteCmsResourceVersionByRequest;
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
        /** @var SiteCmsResourceVersion $siteResourceVersion */
        $siteResourceVersion = $this->getSiteCmsResourceVersionByRequest->__invoke(
            $request
        );

        if (empty($siteResourceVersion)) {
            $this->setLocale->__invoke(null);

            return $next($request, $response);
        }

        $this->setLocale->__invoke($siteResourceVersion->getVersion()->getLocale());

        return $next($request, $response);
    }
}
