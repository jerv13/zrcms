<?php

namespace Zrcms\HttpExpressive\HttpApiSite\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\ContentCore\Site\Fields\FieldsSiteCmsResource;
use Zrcms\HttpExpressive\HttpApi\Validate\DataZfInputFilterService;

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
            FieldsSiteCmsResource::ID => [
                'name' => FieldsSiteCmsResource::ID,
                'required' => false,
                'validators' => [
                ],
            ],

            // @todo use sub filter ['id' => ['required' => true,...]]
            FieldsSiteCmsResource::CONTENT_VERSION => [
                'name' => FieldsSiteCmsResource::CONTENT_VERSION,
                'required' => true,
                'validators' => [
                ],
            ],

            FieldsSiteCmsResource::HOST => [
                'name' => FieldsSiteCmsResource::HOST,
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
