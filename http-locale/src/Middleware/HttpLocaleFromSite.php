<?php

namespace Zrcms\HttpLocale\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\Locale\Api\SetLocale;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpLocaleFromSite implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return mixed|ResponseInterface
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Reliv\Locale\Exception\LocaleException
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $params = $request->getQueryParams();

        $requestLocale = Property::getString(
            $params,
            self::PARAM_LOCALE
        );

        if ($this->allowQueryParamLocale && !empty($requestLocale)) {
            $this->setLocale->__invoke($requestLocale);

            return $delegate->process($request);
        }

        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            $this->setLocale->__invoke(null);

            return $delegate->process($request);
        }

        $siteLocale = $siteCmsResource->getContentVersion()->getLocale();

        $this->setLocale->__invoke($siteLocale);

        return $delegate->process(
            $request->withAttribute(self::ATTRIBUTE_SITE_LOCALE, $siteLocale)
        );
    }
}
