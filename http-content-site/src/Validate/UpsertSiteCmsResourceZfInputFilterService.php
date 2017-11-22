<?php

namespace Zrcms\HttpContentSite\Validate;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\HttpContent\Validate\DataZfInputFilterService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertSiteCmsResourceZfInputFilterService extends DataZfInputFilterService
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
