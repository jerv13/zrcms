<?php

namespace Zrcms\HttpExpressive1\HttpApi\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\ComponentToArray;
use Zrcms\Content\Model\PropertiesComponent;
use Zrcms\HttpExpressive1\Model\JsonApiResponse;
use Zrcms\HttpExpressive1\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponent
{
    const SOURCE = 'zrcms-find-component';

    /**
     * @var \Zrcms\Content\Api\Repository\FindComponent
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
     * @param \Zrcms\Content\Api\Repository\FindComponent $findComponent
     * @param ComponentToArray                            $componentToArray
     * @param string                                      $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\FindComponent $findComponent,
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
            PropertiesComponent::NAME
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

            return new JsonApiResponse(
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

            return new JsonApiResponse(
                null,
                $apiMessages,
                404
            );
        }

        $result = $this->componentToArray->__invoke(
            $component
        );

        return new JsonApiResponse(
            $result
        );
    }
}
