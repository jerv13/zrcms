<?php

namespace Zrcms\HttpAssets\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentCss implements MiddlewareInterface
{
    protected $findComponentsBy;
    protected $getComponentCss;
    protected $headers;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentCss  $getComponentCss
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentCss $getComponentCss,
        array $headers = ['content-type' => 'text/css']
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->getComponentCss = $getComponentCss;
        $this->headers = $headers;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     * @throws \Exception
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $componentType = $request->getAttribute('zrcms-component-type');

        // @todo Validate types

        $components = $this->findComponentsBy->__invoke(
            [FieldsComponentConfig::TYPE => $componentType]
        );

        $content = $this->getComponentCss->__invoke(
            $request,
            $components
        );

        return new HtmlResponse(
            $content,
            200,
            $this->headers
        );
    }
}
