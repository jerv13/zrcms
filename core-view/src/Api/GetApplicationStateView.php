<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\CoreView\Exception\ViewDataNotFound;

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
                'requestPath' => $request->getUri()->getPath(),
            ],
            'layout' => [
                'themeName' => null,
                'layout' => null,
            ],
        ];

        $getViewOptions = $request->getAttribute(
            GetViewByRequest::REQUEST_ATTRIBUTE_GET_VIEW_OPTIONS,
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
                'requestPath' => $request->getUri()->getPath(),
            ],
            'layout' => [
                'themeName' => $layoutCmsResource->getThemeName(),
                'name' => $layoutCmsResource->getName(),
            ],
        ];

        return $viewState;

    }
}
