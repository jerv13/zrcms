Config Examples
===============

~~~php
// Attribute Validator EXAMPLE 
AttributesZfInputFilterService::class => [
    'arguments' => [
        ServiceAwareFactory::class,
        [
            'literal' => [
                // zf-input-filter-service config
                'test1' => [
                    'name' => 'test1',
                    'required' => true,
                    'validators' => [
                        [
                            // Invoked
                            'name' => 'ZfInputFilterService\Validator\Test',
                            'options' => [
                                'test' => 'validatorOptionInvoked',
                                'messages' => [
                                    'TEST' => 'validatorMessageTemplateInvoked',
                                ],
                            ],
                        ],
                        [
                            // Service
                            'name' => 'ZfInputFilterService\Validator\TestService',
                            'service' => true,
                            'options' => [
                                'test' => 'validatorOptionService',
                                'messages' => [
                                    'TEST' => 'validatorMessageTemplateService',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ],
    ],
],

// Data Validator EXAMPLE 
DataZfInputFilterService::class => [
    'arguments' => [
        ServiceAwareFactory::class,
        [
            'literal' => [
                // zf-input-filter-service config
                'test1' => [
                    'name' => 'test1',
                    'required' => true,
                    'validators' => [
                        [
                            // Invoked
                            'name' => 'ZfInputFilterService\Validator\Test',
                            'options' => [
                                'test' => 'validatorOptionInvoked',
                                'messages' => [
                                    'TEST' => 'validatorMessageTemplateInvoked',
                                ],
                            ],
                        ],
                        [
                            // Service
                            'name' => 'ZfInputFilterService\Validator\TestService',
                            'service' => true,
                            'options' => [
                                'test' => 'validatorOptionService',
                                'messages' => [
                                    'TEST' => 'validatorMessageTemplateService',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ],
    ],
],
~~~
