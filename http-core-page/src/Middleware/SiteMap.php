<?php

namespace Zrcms\HttpCorePage\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
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
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param FindPageCmsResourcesBy      $findPageCmsResourcesBy
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

        $entries = [];

        /** @var PageCmsResource $pageCmsResource */
        foreach ($pageCmsResources as $pageCmsResource) {
            $entries[] = [
                'loc' => $siteCmsResource->getHost() . $pageCmsResource->getPath(),
                'lastmod' => $pageCmsResource->getModifiedDateObject()->format('Y-m-d'),
                'changefreq' => 'weekly', // @todo This should be a real value
                'priority' => '1', // @todo This should be a real value
            ];
        }

        $content = $this->render(
            $request,
            $entries
        );

        return new HtmlResponse(
            $content,
            200,
            ['content-type' => 'text/xml']
        );
    }

    /**
     * @todo This should be a Zrcms\Core\Api\Render\Render
     *
     * @param ServerRequestInterface $request
     * @param                        $data
     * @param array                  $options
     *
     * @return string
     */
    protected function render(
        ServerRequestInterface $request,
        $data,
        array $options = []
    ): string {
        $content = ''
            . '<?xml version="1.0" encoding="utf-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n"
            . '   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n"
            . '   xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9'
            . ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        foreach ($data as $entry) {
            $content .= ''
                . '<url>' . "\n"
                . '    <loc>' . $entry['loc'] . '</loc>' . "\n"
                . '    <lastmod>' . $entry['lastmod'] . '8</lastmod>' . "\n"
                . '    <changefreq>' . $entry['changefreq'] . '</changefreq>' . "\n"
                . '    <priority>' . $entry['priority'] . '</priority>' . "\n"
                . '</url>' . "\n";
        }

        $content = '</urlset>' . "\n";

        return $content;
    }
}
