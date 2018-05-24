<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Model\View;
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
     *
     * @return array
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array {
        try {
            $view = $this->getViewByRequest->__invoke(
                $request,
                $this->getViewByRequestOptions
            );
        } catch (ViewDataNotFound $exception) {
            $view = null;
        }

        $requestedPath = $this->findOriginalPath($request);

        // @todo This makes extra DB call
        $requestPathPageCmsResource = $this->findNormalPageCmsResource(
            $view,
            $requestedPath
        );

        return [
            'site' => $this->buildSiteState($view),
            'page' => $this->buildPageState($view),
            'pageRequested' => $this->buildPageRequestedState($view, $requestPathPageCmsResource),
            'layout' => $this->buildLayoutState($view),
            'renderState' => $this->buildRenderState($view, $requestedPath, $requestPathPageCmsResource),
            'siteContainers' => $this->buildSiteContainersState($view),
            'viewStrategy' => $this->buildViewStrategyState($view, $requestedPath),
        ];
    }

    /**
     * @param View|null $view
     *
     * @return array
     */
    protected function buildSiteState($view)
    {
        $siteState = [
            'contentVersionId' => null,
            'id' => null,
            'locale' => null,
            'published' => null,
            'title' => null,
        ];

        if (empty($view)) {
            return $siteState;
        }
        $siteCmsResource = $view->getSiteCmsResource();

        $siteState['contentVersionId'] = $siteCmsResource->getContentVersionId();
        $siteState['id'] = $siteCmsResource->getId();
        $siteState['locale'] = $siteCmsResource->getLocale();
        $siteState['published'] = $siteCmsResource->isPublished();
        $siteState['title'] = $siteCmsResource->getContentVersion()->findProperty(FieldsSiteVersion::TITLE);

        return $siteState;
    }

    /**
     * @param View|null $view
     *
     * @return array
     * @throws \Exception
     */
    protected function buildPageState($view)
    {
        $pageState = [
            'contentVersionId' => null,
            'contentVersionCreatedDate' => null,
            'description' => null,
            'id' => null,
            'keywords' => null,
            'path' => null,
            'published' => null,
            'title' => null,
        ];

        if (empty($view)) {
            return $pageState;
        }
        $pageCmsResource = $view->getPageCmsResource();

        $pageState['contentVersionId'] = $pageCmsResource->getContentVersionId();
        $pageState['contentVersionCreatedDate'] = $pageCmsResource->getContentVersion()->getCreatedDate();
        $pageState['description'] = $pageCmsResource->getContentVersion()->getDescription();
        $pageState['id'] = $pageCmsResource->getId();
        $pageState['keywords'] = $pageCmsResource->getContentVersion()->getKeywords();
        $pageState['path'] = $pageCmsResource->getPath();
        $pageState['published'] = $pageCmsResource->isPublished();
        $pageState['title'] = $pageCmsResource->getContentVersion()->findProperty(FieldsPageVersion::TITLE);

        return $pageState;
    }

    /**
     * @param View|null            $view
     * @param PageCmsResource|null $requestPathPageCmsResource
     *
     * @return array
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    protected function buildPageRequestedState($view, $requestPathPageCmsResource)
    {
        $pageRequestedState = [
            'contentVersionId' => null,
            'contentVersionCreatedDate' => null,
            'description' => null,
            'id' => null,
            'keywords' => null,
            'path' => null,
            'published' => null,
            'title' => null,
        ];

        if (empty($view)) {
            return $pageRequestedState;
        }

        if (empty($requestPathPageCmsResource)) {
            return $pageRequestedState;
        }

        $pageRequestedState['contentVersionId']
            = $requestPathPageCmsResource->getContentVersionId();
        $pageRequestedState['contentVersionCreatedDate']
            = $requestPathPageCmsResource->getContentVersion()->getCreatedDate();
        $pageRequestedState['description']
            = $requestPathPageCmsResource->getContentVersion()->getDescription();
        $pageRequestedState['id']
            = $requestPathPageCmsResource->getId();
        $pageRequestedState['keywords']
            = $requestPathPageCmsResource->getContentVersion()->getKeywords();
        $pageRequestedState['path']
            = $requestPathPageCmsResource->getPath();
        $pageRequestedState['published']
            = $requestPathPageCmsResource->isPublished();
        $pageRequestedState['title']
            = $requestPathPageCmsResource->getContentVersion()->findProperty(FieldsPageVersion::TITLE);

        return $pageRequestedState;
    }

    /**
     * @param View|null $view
     *
     * @return array
     */
    protected function buildLayoutState($view)
    {
        $layoutState = [
            'contentVersionId' => null,
            'name' => null,
            'published' => null,
            'themeName' => null,
        ];

        if (empty($view)) {
            return $layoutState;
        }
        $layoutCmsResource = $view->getLayoutCmsResource();

        $layoutState['contentVersionId'] = $layoutCmsResource->getContentVersionId();
        $layoutState['name'] = $layoutCmsResource->getName();
        $layoutState['published'] = $layoutCmsResource->isPublished();
        $layoutState['themeName'] = $layoutCmsResource->getThemeName();

        return $layoutState;
    }

    /**
     * @param View|null            $view
     * @param PageCmsResource|null $requestPathPageCmsResource
     *
     * @return array
     */
    protected function buildRenderState($view, $requestedPath, $requestPathPageCmsResource)
    {
        $renderState = [
            'cmsPage' => false,
            'isPageForPath' => null,
            'renderingPublishedVersion' => null,
        ];

        if (empty($view)) {
            return $renderState;
        }

        $pageCmsResource = $view->getPageCmsResource();
        $isPageForPath = ($pageCmsResource->getPath() == $requestedPath);

        $renderState['cmsPage'] = true;
        $renderState['isPageForPath'] = $isPageForPath;

        if (empty($requestPathPageCmsResource)) {
            return $renderState;
        }

        $renderState['renderingPublishedVersion']
            = ($pageCmsResource->getContentVersionId() === $requestPathPageCmsResource->getContentVersionId());

        return $renderState;
    }

    /**
     * @param View|null $view
     *
     * @return array
     */
    protected function buildSiteContainersState($view)
    {
        $siteContainersState = [];

        if (empty($view)) {
            return $siteContainersState;
        }
        $siteContainerCmsResources = $view->getSiteContainerCmsResources();

        foreach ($siteContainerCmsResources as $siteContainerCmsResource) {
            $siteContainersState[] = [
                'contentVersionId' => $siteContainerCmsResource->getContentVersionId(),
                'published' => $siteContainerCmsResource->isPublished(),
                'name' => $siteContainerCmsResource->getName(),
            ];
        }

        return $siteContainersState;
    }

    /**
     * @param View|null $view
     *
     * @return array
     */
    protected function buildViewStrategyState($view, $requestedPath)
    {
        if (empty($view)) {
            return null;
        }

        return $view->findProperty(
            FieldsView::STRATEGY
        );
    }

    /**
     * @param View|null   $view
     * @param string|null $requestedPath
     *
     * @return null|PageCmsResource
     */
    protected function findNormalPageCmsResource(
        $view,
        $requestedPath
    ) {
        if (empty($view)) {
            return null;
        }
        if (empty($requestedPath)) {
            return null;
        }
        $siteCmsResource = $view->getSiteCmsResource();

        return $this->findPageCmsResourceBySitePath->__invoke(
            $siteCmsResource->getId(),
            $requestedPath,
            null
        );
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
