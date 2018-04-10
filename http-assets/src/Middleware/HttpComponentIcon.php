<?php

namespace Zrcms\HttpAssets\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Stream;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\GetModuleDirectoryFilePath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentIcon implements MiddlewareInterface
{
    const ATTRIBUTE_TYPE = 'zrcms-component-type';
    const ATTRIBUTE_NAME = 'zrcms-component-name';

    protected $findComponent;
    protected $getModuleDirectoryFilePath;
    protected $headers;

    /**
     * @param FindComponent              $findComponent
     * @param GetModuleDirectoryFilePath $getModuleDirectoryFilePath
     * @param array                      $headers
     */
    public function __construct(
        FindComponent $findComponent,
        GetModuleDirectoryFilePath $getModuleDirectoryFilePath,
        array $headers = ['content-type' => 'image/png']
    ) {
        $this->findComponent = $findComponent;
        $this->getModuleDirectoryFilePath = $getModuleDirectoryFilePath;
        $this->headers = $headers;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|Response|HtmlResponse
     * @throws \Exception
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $componentType = $request->getAttribute(self::ATTRIBUTE_TYPE);
        $componentName = $request->getAttribute(self::ATTRIBUTE_NAME);

        // @todo Validate types

        $component = $this->findComponent->__invoke(
            $componentType,
            $componentName
        );

        if (empty($component)) {
            return new HtmlResponse(
                '',
                404,
                ['reason-phrase' => 'NOT FOUND: COMPONENT']
            );
        }

        $icon = $component->findProperty('icon');

        if (empty($icon)) {
            return new HtmlResponse(
                '',
                404,
                ['reason-phrase' => 'NOT FOUND: COMPONENT ICON']
            );
        }

        $realFilePath = $this->getModuleDirectoryFilePath->__invoke(
            $component->getModuleDirectory(),
            $icon,
            get_class($this)
        );

        return new Response(
            new Stream(fopen($realFilePath, 'r')),
            200,
            $this->headers
        );
    }
}
