<?php

namespace Zrcms\ContentDoctrine;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'doctrine' => [
                /** @todo
                'configuration' => [
                    'orm_default' => [
                        'metadata_cache' => 'doctrine_cache',
                        'query_cache' => 'doctrine_cache',
                        'result_cache' => 'doctrine_cache',
                        'hydration_cache' => 'doctrine_cache',
                    ],
                    'cache' => [
                    ],
                ],
                'connection' => [
                    'orm_default' => [
                        'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                        'params' => [
                            'host' => \Reliv\Secrets\Secrets::getValue('db_host'),
                            'port' => \Reliv\Secrets\Secrets::getValue('db_port'),
                            'user' => \Reliv\Secrets\Secrets::getValue('db_user'),
                            'password' => \Reliv\Secrets\Secrets::getValue('db_pass'),
                            'dbname' => \Reliv\Secrets\Secrets::getValue('db_name'),
                        ],
                    ],
                ],
                 **/
            ],
        ];
    }
}
