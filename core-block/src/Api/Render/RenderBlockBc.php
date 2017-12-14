<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Helper\Placeholder\Container;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\CoreBlock\Model\BlockVersion;
use ZrcmsRcmCompatibility\RcmAdapter\GetRcmPluginController;
use ZrcmsRcmCompatibility\RcmAdapter\GetRcmViewRenderer;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class RenderBlockBc implements RenderBlock
{
    const SERVICE_ALIAS = 'bc';

    /**
     * @var GetRcmPluginController
     */
    protected $getRcmPluginController;

    /**
     * @var GetRcmViewRenderer
     */
    protected $getRcmViewRenderer;

    /**
     * @param GetRcmPluginController $getRcmPluginController
     * @param GetRcmViewRenderer     $getRcmViewRenderer
     */
    public function __construct(
        GetRcmPluginController $getRcmPluginController,
        GetRcmViewRenderer $getRcmViewRenderer
    ) {
        $this->getRcmPluginController = $getRcmPluginController;
        $this->getRcmViewRenderer = $getRcmViewRenderer;
    }

    /**
     * @param BlockVersion|Content $blockVersion
     * @param array                $renderTags
     * @param array                $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockVersion,
        array $renderTags,
        array $options = []
    ): string {
        /** @var \Rcm\Plugin\PluginInterface $controller */
        $controller = $this->getRcmPluginController->__invoke($blockVersion->getBlockComponentName());

        $request = new Request();
        $response = new Response();
        $controller->setResponse($response);

        /** @var \Zend\Mvc\MvcEvent $event */
        $event = new MvcEvent();
        $event->setResponse($response);
        $event->setRequest($request);

        $controller->setEvent($event);
        $controller->setRequest($request);
        $controller->setResponse($response);

        $viewModel = $controller->renderInstance(
            $renderTags[FieldsBlock::RENDER_DATA_ID],
            $renderTags[FieldsBlock::RENDER_DATA_CONFIG]
        );

        if ($viewModel instanceof ResponseInterface) {
            //Contains an exit() call!
            $this->handleResponseFromPluginController($viewModel, $blockVersion->getBlockComponentName());

            return '';
        }

        $renderer = $this->getRcmViewRenderer->__invoke();
        /** @var \Zend\View\Helper\Headlink $headLink */
        $headLink = $renderer->plugin('headlink');

        /** @var \Zend\View\Helper\HeadScript $headScript */
        $headScript = $renderer->plugin('headscript');

        $oldContainer = $headLink->getContainer();
        $linkContainer = new Container();
        $headLink->setContainer($linkContainer);

        $oldScriptContainer = $headScript->getContainer();
        $headScriptContainer = new Container();
        $headScript->setContainer($headScriptContainer);

        $html = $renderer->render($viewModel);

        $html = $headLink->toString() . $headScript->toString() . $html;

        //Put the old things back in the PhpRenderer so we don't damage whatever is was doing before us. (seems hacky)
        $headLink->setContainer($oldContainer);
        $headScript->setContainer($oldScriptContainer);

        return $html;
    }

    /**
     * Handles the legacy support for the odd case where plugin controllers return
     * zf2 responses instead of view models
     *
     * @TODO remove all this and throw an exception if the plugin controller doesn't return a view model
     */
    /**
     * @param ResponseInterface $response
     * @param                   $blockVersionName
     *
     * @return void
     */
    public function handleResponseFromPluginController(ResponseInterface $response, $blockVersionName)
    {
//        trigger_error(
//            'Returning responses from plugin controllers is no longer supported.
//                 The following plugin attempted this: ' . $blockVersionName .
//            ' Post to your own route to avoid this problem.',
//            E_USER_WARNING
//        );

        foreach ($response->getHeaders() as $header) {
            header($header->toString());
        }

//        //Some plugins used to return responses like this to signal a redirect to the login page
//        if ($response->getStatusCode() == 401) {
//            $href = '/login?redirect=' . urlencode($request->getUri()->getPath());;
//            echo "You are not authorized to view this page. Try <a href=\"{$href}\">logging in</a> first.";
//            exit;
//        }

        echo $response->getContent();
        exit;
    }
}
