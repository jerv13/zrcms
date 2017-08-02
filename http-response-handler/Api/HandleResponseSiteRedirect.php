<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersion;
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
     * @var FindSiteCmsResourceByHost
     */
    protected $findSiteCmsResourceByHost;

    /**
     * @var FindSiteVersion
     */
    protected $findSiteVersion;

    /**
     * @var FindPageContainerCmsResourceBySitePath
     */
    protected $findPageContainerCmsResourceBySitePath;

    /**
     * @var FindPageContainerVersion
     */
    protected $findPageContainerVersion;

    /**
     * @var int
     */
    protected $redirectStatusCode = 302;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param FindSiteCmsResourceByHost              $findSiteCmsResourceByHost
     * @param FindSiteVersion                        $findSiteVersion
     * @param FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath
     * @param FindPageContainerVersion               $findPageContainerVersion
     * @param int                                    $redirectStatusCode
     * @param array                                  $headers
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost,
        FindSiteVersion $findSiteVersion,
        FindPageContainerCmsResourceBySitePath $findPageContainerCmsResourceBySitePath,
        FindPageContainerVersion $findPageContainerVersion,
        int $redirectStatusCode = 302,
        array $headers = []
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
        $this->findSiteVersion = $findSiteVersion;
        $this->findPageContainerCmsResourceBySitePath = $findPageContainerCmsResourceBySitePath;
        $this->findPageContainerVersion = $findPageContainerVersion;
        $this->redirectStatusCode = $redirectStatusCode;
        $this->headers = $headers;
    }

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
        $uri = $request->getUri();

        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $uri->getHost()
        );

        if (empty($siteCmsResource)) {
            return $response;
        }

        /** @var SiteVersion $siteVersion */
        $siteVersion = $this->findSiteVersion->__invoke(
            $siteCmsResource->getContentVersionId()
        );

        if (empty($siteVersion)) {
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

        $pageContainerCmsResource = $this->findPageContainerCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $path
        );

        if (empty($pageContainerCmsResource)) {
            return $response;
        }

        /** @var PageContainerVersion $pageContainerVersion */
        $pageContainerVersion = $this->findPageContainerVersion->__invoke(
            $pageContainerCmsResource->getContentVersionId()
        );

        if (empty($pageContainerVersion)) {
            return $response;
        }

        $uri = $request->getUri();

        return new RedirectResponse(
            $uri->withPath($path),
            $this->redirectStatusCode
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
