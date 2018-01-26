<?php

namespace Zrcms\HttpApiFields;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpApiFields\Acl\HttpApiIsAllowedApiFindFieldsByModel;
use Zrcms\HttpApiFields\Field\HttpApiFindFieldsByModel;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.api.fields.model.{zrcms-fields-model}' => [
                    'name' => 'zrcms.api.fields.model.{zrcms-fields-model}',
                    'path' => '/zrcms/api/fields/model/{zrcms-fields-model}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedApiFindFieldsByModel::class,
                        'api' => HttpApiFindFieldsByModel::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.api.fields.types' => [
                    'name' => 'zrcms.api.fields.types',
                    'path' => '/zrcms/api/fields/types',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedApiFindFieldsByModel::class,
                        'api' => HttpApiFindFieldsByModel::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
