<?php

namespace Zrcms\HttpCorePage\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteMap
{
    protected $getSiteCmsResourceByRequest;
    protected $findPageCmsResourcesBy;
    
    /**
     * @param GetSiteCmsResourceByRequest      $getSiteCmsResourceByRequest
     * @param FindPageCmsResourcesBy $findPageCmsResourcesBy
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        FindPageCmsResourcesBy $findPageCmsResourcesBy
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->findPageCmsResourcesBy = $findPageCmsResourcesBy;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // @todo return valid site map xml https://en.wikipedia.org/wiki/Sitemaps
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        $pageCmsResources = $this->findPageCmsResourcesBy->__invoke(
            [
                'siteCmsResourceId' => $siteCmsResource->getId(),
            ]
        );

        $xmlEntries = [];

        /** @var PageCmsResource $pageCmsResource */
        foreach ($pageCmsResources as $pageCmsResource) {
            $xmlEntries[] = [
                'loc' => $siteCmsResource->getHost() . $pageCmsResource->getPath(),
                'lastmod' => $pageCmsResource->getModifiedDate(),
                'changefreq' => 'weekly', // @todo This should be a real value
                'priority' => '1', // @todo This should be a real value
            ];
        }

        // @todo Build from template

        return new Response();
    }
}
