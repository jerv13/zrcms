<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Model\ServiceAliasDefault;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'zrcms-service-alias' => [
                ServiceAliasDefault::ZRCMS_DEFAULT => [],
            ],
        ];
    }
}
