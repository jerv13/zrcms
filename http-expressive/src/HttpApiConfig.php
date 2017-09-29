<?php

namespace Zrcms\HttpExpressive;

use Reliv\RcmApiLib\Api\ApiResponse\NewPsrResponseWithTranslatedMessages;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\HttpExpressive\HttpApi\Acl\IsAllowedReadAllComponentConfigs;
use Zrcms\HttpExpressive\HttpApi\Component\ReadAllComponentConfigs;
use Zrcms\HttpExpressive\HttpApi\Params\ParamQuery;
use Zrcms\HttpExpressive\HttpApi\ResponseMutatorJsonRcmApiLibFormat;
use Zrcms\HttpExpressive\HttpApi\Validate\IdAttributeZfInputFilterService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Acl ===========================================
                     */

                    /** ACL EXAMPLE *
                    IsAllowedCheckApi::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                                ]
                            ],

                        ],
                    ],
                    /* */

                    IsAllowedReadAllComponentConfigs::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                                ]
                            ],
                            ['literal' => 'get-register-components']
                        ],
                    ],

                    /**
                     * Action ===========================================
                     */

                    /**
                     * Params ===========================================
                     */

                    ParamQuery::class => [],

                    /**
                     * Repository ===========================================
                     */

                    /**
                     * Validate ===========================================
                     */
                    /** Attribute Validator EXAMPLE *
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
                    /* */

                    IdAttributeZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            ['literal' => 'id'],
                        ],
                    ],

                    /** Data Validator EXAMPLE *
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
                    /* */

                    /**
                     * general ===========================================
                     */

                    ReadAllComponentConfigs::class => [
                        'arguments' => [
                            \Zrcms\Content\Api\Component\ReadAllComponentConfigs::class,
                        ],
                    ],

                    ResponseMutatorJsonRcmApiLibFormat::class => [
                        'arguments' => [
                            NewPsrResponseWithTranslatedMessages::class,
                        ],
                    ],
                ],
            ],

            'routes' => [
                // Find Component CmsResource
                'zrcms.read-all-component-configs' => [
                    'name' => 'zrcms.read-all-component-configs',
                    'path' => '/zrcms/read-all-component-configs',
                    'middleware' => [
                        'acl' => IsAllowedReadAllComponentConfigs::class,
                        'api' => ReadAllComponentConfigs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
