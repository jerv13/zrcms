<?php

namespace Zrcms\HttpApi\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Model\ResponseCodes;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponent
{
    const SOURCE = 'zrcms-find-component';

    protected $findComponent;
    protected $componentToArray;

    /**
     * @param FindComponent    $findComponent
     * @param ComponentToArray $componentToArray
     */
    public function __construct(
        FindComponent $findComponent,
        ComponentToArray $componentToArray
    ) {
        $this->findComponent = $findComponent;
        $this->componentToArray = $componentToArray;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ZrcmsJsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $componentType = (string)$request->getAttribute(
            'type'
        );

        $componentName = (string)$request->getAttribute(
            'name'
        );

        if (empty($componentType)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::ID_NOT_RECEIVED,
                    'Type not received',
                    'find-component:' . $componentName . ':' . $componentType,
                    self::SOURCE
                ),
                400
            );
        }

        if (empty($componentName)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::ID_NOT_RECEIVED,
                    'Name not received',
                    'find-component:' . $componentName . ':' . $componentType,
                    self::SOURCE
                ),
                400
            );
        }

        $component = $this->findComponent->__invoke(
            $componentType,
            $componentName
        );

        if (empty($component)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::FAILED,
                    'Find failed',
                    'find-component:' . $componentName . ':' . $componentType,
                    self::SOURCE
                ),
                404
            );
        }

        $result = $this->componentToArray->__invoke(
            $component
        );

        return new ZrcmsJsonResponse(
            $result
        );
    }
}
