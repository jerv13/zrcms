<?php

namespace Zrcms\HttpApi\Component;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
class HttpApiFindComponent implements MiddlewareInterface
{
    const SOURCE = 'zrcms-find-component';

    const ATTRIBUTE_COMPONENT_TYPE = 'zrcms-component-type';
    const ATTRIBUTE_COMPONENT_NAME = 'zrcms-component-name';

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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $componentType = (string)$request->getAttribute(
            static::ATTRIBUTE_COMPONENT_TYPE
        );

        $componentName = (string)$request->getAttribute(
            static::ATTRIBUTE_COMPONENT_NAME
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
