<?php

namespace Zrcms\HttpCore\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponent
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
     * __invoke
     *
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
        $componentName = (string)$request->getAttribute(
            'name'
        );

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
