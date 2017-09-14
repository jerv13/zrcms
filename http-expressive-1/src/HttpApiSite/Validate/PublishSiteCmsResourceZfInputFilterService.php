<?php

namespace Zrcms\HttpExpressive1\HttpApiSite\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApi\Validate\DataZfInputFilterService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishSiteCmsResourceZfInputFilterService extends DataZfInputFilterService
{
    /**
     * @var array
     */
    protected $inputFilterConfig
        = [
            PropertiesSiteCmsResource::ID => [
                'name' => PropertiesSiteCmsResource::ID,
                'required' => false,
                'validators' => [
                ],
            ],

            // @todo use sub filter ['id' => ['required' => true,...]]
            PropertiesSiteCmsResource::CONTENT_VERSION => [
                'name' => PropertiesSiteCmsResource::CONTENT_VERSION,
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
     */
    public function __construct(
        ServiceAwareFactory $factory
    ) {
        parent::__construct($factory, $this->inputFilterConfig);
    }
}
