<?php

namespace Zrcms\HttpLocale\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\Locale\Api\SetLocale;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpLocaleFromSite
{
    const PARAM_LOCALE = 'site-locale';
    const ATTRIBUTE_SITE_LOCALE = 'zrcms-site-locale';

    protected $setLocale;
    protected $getSiteCmsResourceByRequest;
    protected $allowQueryParamLocale;

    /**
     * @param SetLocale                   $setLocale
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param bool                        $allowQueryParamLocale
     */
    public function __construct(
        SetLocale $setLocale,
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        bool $allowQueryParamLocale = false
    ) {
        $this->setLocale = $setLocale;
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->allowQueryParamLocale = $allowQueryParamLocale;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return mixed
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Reliv\Locale\Exception\LocaleException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $params = $request->getQueryParams();

        $requestLocale = Property::getString(
            $params,
            self::PARAM_LOCALE
        );

        if ($this->allowQueryParamLocale && !empty($requestLocale)) {
            $this->setLocale->__invoke($requestLocale);

            return $next($request, $response);
        }

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            $this->setLocale->__invoke(null);

            return $next($request, $response);
        }

        $siteLocale = $siteCmsResource->getContentVersion()->getLocale();

        $this->setLocale->__invoke($siteLocale);

        return $next(
            $request->withAttribute(self::ATTRIBUTE_SITE_LOCALE, $siteLocale),
            $response
        );
    }
}
