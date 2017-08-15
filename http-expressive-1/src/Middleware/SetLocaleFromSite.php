<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteVersion;
use Zrcms\Locale\Api\SetLocale;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SetLocaleFromSite
{
    /**
     * @var SetLocale
     */
    protected $setLocale;

    /**
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindSiteVersion
     */
    protected $findSiteVersion;

    /**
     * @param SetLocale                 $setLocale
     * @param FindSiteCmsResourceByHost $findSiteCmsResourceByHost
     * @param FindSiteVersion           $findSiteVersion
     */
    public function __construct(
        SetLocale $setLocale,
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindSiteVersion $findSiteVersion
    ) {
        $this->setLocale = $setLocale;
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findSiteVersion = $findSiteVersion;
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
        /** @var SiteCmsResource $siteResource */
        $siteResource = $this->findSiteCmsResourceByHost->__invoke(
            $request->getUri()->getHost()
        );

        if (empty($siteResource)) {
            $this->setLocale->__invoke(null);
            return $next($request, $response);
        }

        /** @var SiteVersion $siteVersion */
        $siteVersion = $this->findSiteVersion->__invoke(
            $siteResource->getContentVersionId()
        );

        if (empty($siteVersion)) {
            $this->setLocale->__invoke(null);
            return $next($request, $response);
        }

        $this->setLocale->__invoke($siteVersion->getLocale());

        return $next($request, $response);
    }
}
