<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Content\Api\Component\ReadAllComponentConfigs;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigContent
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    ReadAllComponentConfigs::class => [
                        'factory' => This\Content\Api\Component\ReadAllComponentConfigsFactory::class
                    ],
                    SearchConfigList::class => [
                        'class' => SearchConfigList::class,
                    ],
                ],
            ],
        ];
    }
}
