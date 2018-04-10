<?php

namespace Zrcms\HttpAssets\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentJs implements MiddlewareInterface
{
    protected $findComponentsBy;
    protected $getComponentJs;
    protected $headers;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentJs   $getComponentJs
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentJs $getComponentJs,
        array $headers = ['content-type' => 'text/javascript']
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->getComponentJs = $getComponentJs;
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

        $content = $this->getComponentJs->__invoke(
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
