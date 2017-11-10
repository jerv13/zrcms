<?php

namespace Zrcms\HttpExpressive\HttpApiSite\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
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
            'id' => [
                'name' => 'id',
                'required' => false,
                'validators' => [
                ],
            ],

            // @todo use sub filter ['id' => ['required' => true,...]]
            'contentVersion' => [
                'name' => 'contentVersion',
                'required' => true,
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
