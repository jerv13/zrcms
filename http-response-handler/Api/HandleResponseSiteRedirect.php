<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseSiteRedirect implements HandleResponse
{
    protected $statusPropertyMap
        = [
            '404' => PropertiesSiteVersion::NOT_FOUND_PAGE,
            '401' => PropertiesSiteVersion::NOT_AUTHORIZED_PAGE,
        ];

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $options
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface
    {
        /** @var SiteVersion $siteVersion */
        $siteVersion = Param::get(
            $options,
            HandleResponseOptions::SITE_VERSION
        );

        if (!$siteVersion instanceof SiteVersion) {
            return $response;
        }

        $propertyName = $this->getSiteProperty(
            $response->getStatusCode()
        );

        if (empty($propertyName)) {
            return $response;
        }

        $path = $siteVersion->getProperty(
            $propertyName
        );

        if (empty($path)) {
            return $response;
        }

        $uri = $request->getUri();

        $redirectStatusCode = Param::get(
            $options,
            HandleResponseOptions::REDIRECT_STATUS_CODE,
            302
        );

        return new RedirectResponse(
            $uri->withPath($path),
            $redirectStatusCode
        );
    }

    /**
     * @param $statusCode
     *
     * @return mixed|null
     */
    protected function getSiteProperty($statusCode)
    {
        $mapStatusCode = (string)$statusCode;

        return Param::get(
            $this->statusPropertyMap,
            $mapStatusCode
        );
    }
}
