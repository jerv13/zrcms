<?php

namespace Zrcms\HttpExpressive1\HttpValidator;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteCmsResourcePublishZfInputFilterService extends DataZfInputFilterService
{
    /**
     * @var array
     */
    protected $inputFilterConfig = [
        PropertiesSiteCmsResource::ID => [
            'name' => PropertiesSiteCmsResource::ID,
            'required' => false,
            'validators' => [
            ],
        ],

        PropertiesSiteCmsResource::CONTENT_VERSION_ID => [
            'name' => PropertiesSiteCmsResource::CONTENT_VERSION_ID,
            'required' => true,
            'validators' => [
            ],
        ],

        PropertiesSiteCmsResource::HOST => [
            'name' => PropertiesSiteCmsResource::HOST,
            'required' => false,
            'validators' => [
            ],
        ],
    ];

    /**
     * @param ServiceAwareFactory $factory
     * @param HandleResponseApi   $handleResponse
     */
    public function __construct(
        ServiceAwareFactory $factory,
        HandleResponseApi $handleResponse
    ) {
        parent::__construct($factory, $this->inputFilterConfig, $handleResponse);
    }
}
