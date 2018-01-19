<?php

namespace Zrcms\HttpApi\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
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
            $apiMessages = [
                'type' => 'find-component:' . $componentName . ':' . $componentType,
                'message' => 'Type not received',
                'source' => self::SOURCE,
                'code' => ResponseCodes::ID_NOT_RECEIVED,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                400
            );
        }

        if (empty($componentName)) {
            $apiMessages = [
                'type' => 'find-component:' . $componentName . ':' . $componentType,
                'message' => 'Name not received',
                'source' => self::SOURCE,
                'code' => ResponseCodes::ID_NOT_RECEIVED,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                400
            );
        }

        $component = $this->findComponent->__invoke(
            $componentType,
            $componentName
        );

        if (empty($component)) {
            $apiMessages = [
                'type' => 'find-component:' . $componentName . ':' . $componentType,
                'message' => 'Find failed',
                'source' => self::SOURCE,
                'code' => ResponseCodes::FAILED,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
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
