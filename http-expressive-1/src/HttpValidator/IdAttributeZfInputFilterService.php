<?php

namespace Zrcms\HttpExpressive1\HttpValidator;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IdAttributeZfInputFilterService extends AttributesZfInputFilterService
{
    /**
     * @param ServiceAwareFactory $factory
     * @param HandleResponseApi   $handleResponse
     * @param string              $idPropertyName
     */
    public function __construct(
        ServiceAwareFactory $factory,
        HandleResponseApi $handleResponse,
        string $idPropertyName = 'id'
    ) {
        $inputFilterConfig = [
            $idPropertyName => [
                'name' => $idPropertyName,
                'required' => true,
                'validators' => [
                ],
            ],
        ];

        parent::__construct($factory, $inputFilterConfig, $handleResponse);
    }
}
