<?php

namespace Zrcms\HttpExpressive1\HttpResponseMutator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive1\HttpAlways\RenderPage;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithView;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPage implements ResponseMutator
{
    /**
     * @var FindBasicComponent
     */
    protected $findBasicComponent;

    /**
     * @var RenderPage
     */
    protected $renderPage;

    /**
     * @param FindBasicComponent $findBasicComponent
     * @param RenderPage         $renderPage
     * @param array              $validHeaders
     */
    public function __construct(
        FindBasicComponent $findBasicComponent,
        RenderPage $renderPage,
        array $validHeaders = []
    ) {
        $this->findBasicComponent = $findBasicComponent;
        $this->renderPage = $renderPage;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $options
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface
    {
        $status = (string)$response->getStatusCode();

        /** @var View $view */
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        /** @var HttpExpressiveComponent $component */
        $component = $this->findBasicComponent->__invoke(
            HttpExpressiveComponent::NAME
        );

        $statusPage = $component->findStatusPage($status);

        // If we have a view, try to get the $statusPage from site
        if (!empty($view)) {
            $siteVersion = $view->getSite();
            $statusPage = $siteVersion->findStatusPage(
                $status,
                $statusPage
            );
        }

        if (empty($statusPage)) {
            return $response;
        }

        $uri = $request->getUri();

        $uri = $uri->withPath($statusPage);

        $request->withUri($uri);

        // this will stop loops
        $finalResponse = $response->withStatus(
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        return $this->renderPage->__invoke(
            $request->withUri($uri),
            $response,
            function ($req, $res) use ($finalResponse) {
                return $finalResponse;
            }
        );
    }

    /**
     * @param $status
     * @param $statusPage
     * @param $request
     * @param $renderMiddleware
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        $status,
        $statusPage,
        $request,
        $renderMiddleware
    ) {
        if (empty($statusPage)) {
            throw new CanNotHandleResponse(
                "No status page found for status: {$status}"
            );
        }
    }
}
