<?php

namespace Zrcms\HttpApi\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponent
{
    const SOURCE = 'zrcms-find-component';

    /**
     * @var \Zrcms\Core\Api\Component\FindComponent
     */
    protected $findComponent;

    /**
     * @var ComponentToArray
     */
    protected $componentToArray;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Core\Api\Component\FindComponent $findComponent
     * @param ComponentToArray                            $componentToArray
     * @param string                                      $name
     */
    public function __construct(
        \Zrcms\Core\Api\Component\FindComponent $findComponent,
        ComponentToArray $componentToArray,
        string $name
    ) {
        $this->findComponent = $findComponent;
        $this->componentToArray = $componentToArray;
        $this->name = $name;
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
                'type' => $this->name,
                'value' => 'Type not received',
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
                'type' => $this->name,
                'value' => 'Name not received',
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
                'type' => $this->name,
                'value' => 'Find failed',
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
