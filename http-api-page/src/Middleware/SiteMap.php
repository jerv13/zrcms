<?php

namespace Zrcms\HttpApiPage\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowed;
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
    protected $isAllowed;
    protected $defaultProtocol;

    /**
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param FindPageCmsResourcesBy      $findPageCmsResourcesBy
     * @param IsAllowed                   $isAllowed
     * @param string                      $defaultProtocol
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        FindPageCmsResourcesBy $findPageCmsResourcesBy,
        IsAllowed $isAllowed,
        string $defaultProtocol = 'https://'
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->findPageCmsResourcesBy = $findPageCmsResourcesBy;
        $this->isAllowed = $isAllowed;
        $this->defaultProtocol = $defaultProtocol;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface|HtmlResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        $pageCmsResources = $this->findPageCmsResourcesBy->__invoke(
            [
                'siteCmsResourceId' => $siteCmsResource->getId(),
                'published' => true,
            ]
        );

        $entries = [];

        /** @var PageCmsResource $pageCmsResource */
        foreach ($pageCmsResources as $pageCmsResource) {
            $isAllowed = $this->isAllowed->__invoke(
                $request,
                [
                    'page-cms-resource' => $pageCmsResource
                ]
            );

            if (!$isAllowed) {
                continue;
            }

            $entries[] = [
                'loc' => $this->defaultProtocol . $siteCmsResource->getHost() . $pageCmsResource->getPath(),
                'lastmod' => $pageCmsResource->getModifiedDateObject()->format('Y-m-d'),
                'changefreq' => $this->getChangeFrequency($pageCmsResource),
                'priority' => $this->getPriority($pageCmsResource),
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
     * @todo Implement this logic
     * @param PageCmsResource $pageCmsResource
     *
     * @return string
     */
    protected function getChangeFrequency(PageCmsResource $pageCmsResource)
    {
        return 'weekly';
    }

    /**
     * @todo Implement this logic
     * @param PageCmsResource $pageCmsResource
     *
     * @return string
     */
    protected function getPriority(PageCmsResource $pageCmsResource)
    {
        return '1';
    }

    /**
     * @todo This should be a Zrcms\Core\Api\Render\Render
     *
     * @param ServerRequestInterface $request
     * @param                        $data
     * @param array $options
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
                . '    <url>' . "\n"
                . '        <loc>' . $entry['loc'] . '</loc>' . "\n"
                . '        <lastmod>' . $entry['lastmod'] . '8</lastmod>' . "\n"
                . '        <changefreq>' . $entry['changefreq'] . '</changefreq>' . "\n"
                . '        <priority>' . $entry['priority'] . '</priority>' . "\n"
                . '    </url>' . "\n";
        }

        $content .= '</urlset>' . "\n";

        return $content;
    }
}
