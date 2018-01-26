<?php

namespace Zrcms\Locale;

use Zrcms\Locale\Api\DefaultLocal;

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
            'zrcms-locale-default' => DefaultLocal::get()
        ];
    }
}
