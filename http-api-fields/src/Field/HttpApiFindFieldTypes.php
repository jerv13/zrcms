<?php

namespace Zrcms\HttpApiFields\Field;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\FieldRat\Api\FieldType\FieldTypesToArray;
use Reliv\FieldRat\Api\FieldType\ListFieldTypes;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindFieldTypes implements MiddlewareInterface
{
    protected $listFieldTypes;
    protected $fieldTypesToArray;

    /**
     * @param ListFieldTypes    $listFieldTypes
     * @param FieldTypesToArray $fieldTypesToArray
     */
    public function __construct(
        ListFieldTypes $listFieldTypes,
        FieldTypesToArray $fieldTypesToArray
    ) {
        $this->listFieldTypes = $listFieldTypes;
        $this->fieldTypesToArray = $fieldTypesToArray;
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
        return new ZrcmsJsonResponse(
            $this->fieldTypesToArray->__invoke(
                $this->listFieldTypes->__invoke()
            ),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
