<?php

namespace Zrcms\HttpAssets\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentJs
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
