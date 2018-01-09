<?php

namespace Zrcms\HttpAssets\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentCss
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
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
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
