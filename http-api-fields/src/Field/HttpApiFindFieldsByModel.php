<?php

namespace Zrcms\HttpApiFields\Field;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\FieldRat\Api\Field\FieldsToArray;
use Reliv\FieldRat\Api\Field\FindFieldsByModel;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindFieldsByModel
{
    const SOURCE = 'http-api-find-fields-by-model';
    const ATTRIBUTE_FIELDS_MODEL = 'field-rat-fields-model';

    protected $fieldsByModel;
    protected $fieldsToArray;
    protected $notFoundStatusDefault;

    public function __construct(
        FindFieldsByModel $fieldsByModel,
        FieldsToArray $fieldsToArray,
        int $notFoundStatusDefault = 404
    ) {
        $this->fieldsByModel = $fieldsByModel;
        $this->fieldsToArray = $fieldsToArray;
        $this->notFoundStatusDefault = $notFoundStatusDefault;
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
        $model = $request->getAttribute(self::ATTRIBUTE_FIELDS_MODEL);

        $fields = $this->fieldsByModel->__invoke(
            $model
        );

        if (empty($fields)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatusDefault,
                    'Not Found',
                    $request->getAttribute(self::ATTRIBUTE_FIELDS_MODEL),
                    self::SOURCE
                ),
                $this->notFoundStatusDefault,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return new ZrcmsJsonResponse(
            $this->fieldsToArray->__invoke(
                $fields
            ),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
