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
                'title' => null,
                'locale' => null,
            ],
            'page' => [
                'path' => null,
                'id' => null,
                'title' => null,
                'keywords' => null,
                'description' => null,
                'requestPath' => $this->findOriginalPath($request),
            ],
            'layout' => [
                'themeName' => null,
                'layout' => null,
            ],
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
                'title' => $siteCmsResource->getContentVersion()->findProperty(FieldsSiteVersion::TITLE),
                'locale' => $siteCmsResource->getLocale(),
            ],
            'page' => [
                'id' => $pageCmsResource->getId(),
                'path' => $pageCmsResource->getPath(),
                'title' => $pageVersion->getTitle(),
                'keywords' => $pageVersion->getKeywords(),
                'description' => $pageVersion->getDescription(),
                'requestPath' => $this->findOriginalPath($request),
            ],
            'layout' => [
                'themeName' => $layoutCmsResource->getThemeName(),
                'name' => $layoutCmsResource->getName(),
            ],
        ];

        return $viewState;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function findOriginalPath(ServerRequestInterface $request)
    {
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

        return null;
    }
}
