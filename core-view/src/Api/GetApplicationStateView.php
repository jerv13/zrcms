<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpViewRender\Request\RequestWithOriginalUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateView implements GetApplicationState
{
    const APPLICATION_STATE_KEY = 'view';

    protected $findPageCmsResourceBySitePath;
    protected $getViewByRequest;
    protected $getViewByRequestOptions;

    /**
     * @param FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath
     * @param GetViewByRequest              $getViewByRequest
     * @param array                         $getViewByRequestOptions
     */
    public function __construct(
        FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath,
        GetViewByRequest $getViewByRequest,
        array $getViewByRequestOptions = []
    ) {
        $this->findPageCmsResourceBySitePath = $findPageCmsResourceBySitePath;
        $this->getViewByRequest = $getViewByRequest;
        $this->getViewByRequestOptions = $getViewByRequestOptions;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $viewState = [
            'site' => [
                'contentVersionId' => null,
                'id' => null,
                'locale' => null,
                'published' => null,
                'title' => null,
            ],
            'page' => [
                'cmsPage' => false,
                'contentVersionId' => null,
                'description' => null,
                'id' => null,
                'keywords' => null,
                'path' => null,
                'published' => null,
                'requestPathContentVersionId' => null,
                'requestPath' => $this->findOriginalPath($request, $request->getUri()->getPath()),
                'isPageForPath' => null,
                'title' => null,
            ],
            'layout' => [
                'contentVersionId' => null,
                'name' => null,
                'published' => null,
                'themeName' => null,
            ],
            'site-containers' => [],
            'view-strategy' => null,
        ];

        try {
            $view = $this->getViewByRequest->__invoke(
                $request,
                $this->getViewByRequestOptions
            );
        } catch (ViewDataNotFound $exception) {
            return $viewState;
        }

        $siteCmsResource = $view->getSiteCmsResource();
        $pageCmsResource = $view->getPageCmsResource();
        $pageVersion = $pageCmsResource->getContentVersion();
        $layoutCmsResource = $view->getLayoutCmsResource();
        $siteContainerCmsResources = $view->getSiteContainerCmsResources();
        $requestedPath = $this->findOriginalPath($request);

        $isPageForPath = ($pageCmsResource->getPath() == $requestedPath);

        $requestPathContentVersionId = $this->findNormalPageVersionId(
            $siteCmsResource->getId(),
            $pageVersion,
            $requestedPath
        );

        $viewState = [
            'site' => [
                'contentVersionId' => $siteCmsResource->getContentVersionId(),
                'id' => $siteCmsResource->getId(),
                'locale' => $siteCmsResource->getLocale(),
                'published' => $siteCmsResource->isPublished(),
                'title' => $siteCmsResource->getContentVersion()->findProperty(FieldsSiteVersion::TITLE),
            ],
            'page' => [
                'cmsPage' => true,
                'contentVersionId' => $pageVersion->getId(),
                'description' => $pageVersion->getDescription(),
                'id' => $pageCmsResource->getId(),
                'keywords' => $pageVersion->getKeywords(),
                'path' => $pageCmsResource->getPath(),
                'published' => $pageCmsResource->isPublished(),
                'requestPath' => $requestedPath,
                'requestPathContentVersionId' => $requestPathContentVersionId,
                'isPageForPath' => $isPageForPath,
                'title' => $pageVersion->getTitle(),
            ],
            'layout' => [
                'contentVersionId' => $layoutCmsResource->getContentVersionId(),
                'name' => $layoutCmsResource->getName(),
                'published' => $layoutCmsResource->isPublished(),
                'themeName' => $layoutCmsResource->getThemeName(),
            ],
            'site-containers' => $this->getSiteContainersState($siteContainerCmsResources),
            'view-strategy' => $view->findProperty(
                FieldsView::STRATEGY
            ),
        ];

        return $viewState;
    }

    /**
     * @param ContainerCmsResource[] $siteContainerCmsResources
     *
     * @return array
     */
    protected function getSiteContainersState(
        array $siteContainerCmsResources
    ): array {
        $state = [];

        foreach ($siteContainerCmsResources as $siteContainerCmsResource) {
            $state[] = [
                'contentVersionId' => $siteContainerCmsResource->getContentVersionId(),
                'published' => $siteContainerCmsResource->isPublished(),
                'path' => $siteContainerCmsResource->getPath(),
            ];
        }

        return $state;
    }

    /**
     * @param string      $siteCmsResourceId
     * @param PageVersion $pageVersionFromView
     * @param string      $requestedPath
     *
     * @return null|string
     */
    protected function findNormalPageVersionId(
        string $siteCmsResourceId,
        PageVersion $pageVersionFromView,
        string $requestedPath
    ) {
        if ($pageVersionFromView->getPath() == $requestedPath) {
            return $pageVersionFromView->getId();
        }

        $normalPathPageCmsResource = $this->findPageCmsResourceBySitePath->__invoke(
            $siteCmsResourceId,
            $requestedPath,
            null
        );

        if (empty($normalPathPageCmsResource)) {
            return null;
        }

        return $normalPathPageCmsResource->getContentVersionId();
    }

    /**
     * @param ServerRequestInterface $request
     * @param mixed                  $default
     *
     * @return null|string
     */
    protected function findOriginalPath(
        ServerRequestInterface $request,
        $default = null
    ) {
        /** @var UriInterface $originalUri */
        $originalUri = $request->getAttribute(
            RequestWithOriginalUri::ATTRIBUTE_ORIGINAL_URI,
            null
        );

        if ($originalUri instanceof UriInterface) {
            return $originalUri->getPath();
        }

        $originalUri = $request->getAttribute(
            ResponseMutatorStatusPage::ATTRIBUTE_REQUEST_URI,
            null
        );

        if ($originalUri instanceof UriInterface) {
            return $originalUri->getPath();
        }

        // From \Zend\Stratigility\Middleware\OriginalMessages
        $originalUri = $request->getAttribute(
            'originalUri',
            null
        );

        if ($originalUri instanceof UriInterface) {
            return $originalUri->getPath();
        }

        return $default;
    }
}
