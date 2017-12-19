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
class ComponentCss
{
    protected $findComponentsBy;
    protected $getComponentCss;
    protected $componentType;
    protected $headers;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentCss  $getComponentCss
     * @param string           $componentType
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentCss $getComponentCss,
        string $componentType,
        array $headers = ['content-type' => 'text/css']
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->getComponentCss = $getComponentCss;
        $this->componentType = $componentType;
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
        $components = $this->findComponentsBy->__invoke(
            [FieldsComponentConfig::TYPE => $this->componentType]
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
