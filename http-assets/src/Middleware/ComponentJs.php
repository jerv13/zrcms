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
class ComponentJs
{
    protected $findComponentsBy;
    protected $getComponentJs;
    protected $componentType;
    protected $headers;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param GetComponentJs   $getComponentJs
     * @param string           $componentType
     * @param array            $headers
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        GetComponentJs $getComponentJs,
        string $componentType,
        array $headers = ['content-type' => 'text/javascript']
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->getComponentJs = $getComponentJs;
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
