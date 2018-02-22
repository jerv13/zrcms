<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpViewRender\Request\RequestWithGetViewOptions;
use Zrcms\HttpViewRender\Request\RequestWithOriginalUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateView implements GetApplicationState
{
    const APPLICATION_STATE_KEY = 'view';

    protected $getViewByRequest;

    /**
     * @param GetViewByRequest $getViewByRequest
     */
    public function __construct(
        GetViewByRequest $getViewByRequest
    ) {
        $this->getViewByRequest = $getViewByRequest;
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
                'id' => null,
                'locale' => null,
                'published' => null,
                'title' => null,
            ],
            'page' => [
                'cmsPage' => false,
                'description' => null,
                'id' => null,
                'keywords' => null,
                'path' => null,
                'published' => null,
                'requestPath' => $this->findOriginalPath($request, $request->getUri()->getPath()),
                'title' => null,
            ],
            'layout' => [
                'name' => null,
                'published' => null,
                'themeName' => null,
            ],
            GetViewByRequest::VIEW_PROPERTY_GET_VIEW_API_NAME => null,
        ];

        $getViewOptions = $request->getAttribute(
            RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        try {
            $view = $this->getViewByRequest->__invoke(
                $request,
                $getViewOptions
            );
        } catch (ViewDataNotFound $exception) {
            return $viewState;
        }

        $siteCmsResource = $view->getSiteCmsResource();
        $pageCmsResource = $view->getPageCmsResource();
        $pageVersion = $pageCmsResource->getContentVersion();
        $layoutCmsResource = $view->getLayoutCmsResource();

        $viewState = [
            'site' => [
                'id' => $siteCmsResource->getId(),
                'locale' => $siteCmsResource->getLocale(),
                'published' => $siteCmsResource->isPublished(),
                'title' => $siteCmsResource->getContentVersion()->findProperty(FieldsSiteVersion::TITLE),
            ],
            'page' => [
                'cmsPage' => true,
                'description' => $pageVersion->getDescription(),
                'id' => $pageCmsResource->getId(),
                'keywords' => $pageVersion->getKeywords(),
                'path' => $pageCmsResource->getPath(),
                'published' => $pageCmsResource->isPublished(),
                'requestPath' => $this->findOriginalPath($request),
                'title' => $pageVersion->getTitle(),
            ],
            'layout' => [
                'name' => $layoutCmsResource->getName(),
                'published' => $layoutCmsResource->isPublished(),
                'themeName' => $layoutCmsResource->getThemeName(),
            ],
            'view-type' => $view->findProperty(
                GetViewByRequest::VIEW_PROPERTY_GET_VIEW_API_NAME
            ),
        ];

        return $viewState;
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
