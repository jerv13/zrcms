<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Psr\Container\ContainerInterface;
use Rcm\Plugin\PluginInterface;
use Zend\Expressive\ZendView\HelperPluginManagerFactory;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Helper\Placeholder\Container;
use Zend\View\HelperPluginManager;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\AggregateResolver;
use Zend\View\Resolver\TemplatePathStack;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\PropertiesBlock;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class RenderBlockBc implements RenderBlock
{
    const SERVICE_ALIAS = 'bc';

    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * Constructor.
     *
     * @param ContainerInterface $serviceManager
     */
    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        //$this->renderer = $serviceManager->get('ViewRenderer');
    }

    /**
     * @return PhpRenderer
     */
    protected function getRender()
    {
        $helperFactory = new HelperPluginManagerFactory();

        $helperPluginManager = $helperFactory->__invoke($this->serviceManager);

        $renderer = new PhpRenderer();

        $config = $this->serviceManager->get('config');

        // Configure it:
        $resolver = new AggregateResolver();
        //        $resolver->attach(
        //            new TemplateMapResolver(include 'config/templates.php'),
        //            100
        //        );
        $resolver->attach(
            (new TemplatePathStack())
                ->setPaths($config['view_manager']['template_path_stack'])
        );
        $renderer->setResolver($resolver);

        $renderer->setHelperPluginManager(
            $helperPluginManager
        );

        // Inject:
        //$renderer = new ZendViewRenderer($renderer);

        return $renderer;
    }

    /**
     * @param BlockVersion|Content $blockVersion
     * @param array                $renderData
     * @param array                $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockVersion,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var \Rcm\Plugin\PluginInterface $controller */
        $controller = $this->getPluginController($blockVersion->getBlockComponentName());

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
            $renderData[PropertiesBlock::RENDER_DATA_ID],
            $renderData[PropertiesBlock::RENDER_DATA_CONFIG]
        );

        if ($viewModel instanceof ResponseInterface) {
            //Contains an exit() call!
            $this->handleResponseFromPluginController($viewModel, $blockVersion->getBlockComponentName());

            return '';
        }

        $renderer = $this->getRender();
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
     * Get an instantiated plugin controller
     *
     * @param $pluginName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getPluginController($pluginName)
    {
        /*
         * Deprecated.  All controllers should come from the controller manager
         * now and not the service manager.
         *
         * @todo Remove if statement once plugins have been converted.
         */
        if ($this->serviceManager->has($pluginName)) {
            $serviceManager = $this->serviceManager;
        } else {
            $serviceManager = $this->serviceManager->get('ControllerLoader');
        }

        if (!$serviceManager->has($pluginName)) {
            throw new \Exception(
                "Plugin $pluginName is not loaded or configured. Check
            config/application.config.php"
            );
        }

        $pluginController = $serviceManager->get($pluginName);

        //Plugin controllers must implement this interface
        if (!$pluginController instanceof PluginInterface) {
            throw new \Exception(
                'Class "' . get_class($pluginController) . '" for plugin "'
                . $pluginName . '" does not implement '
                . '\Rcm\Plugin\PluginInterface'
            );
        }

        return $pluginController;
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
