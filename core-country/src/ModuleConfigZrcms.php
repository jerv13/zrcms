<?php

namespace Zrcms\CoreCountry;

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
            'zrcms-country-default' => [
                'iso3' => 'USA',
                'iso2' => 'US',
                'name' => 'United States'
            ],
            'zrcms-components' => [
                'basic.zrcms-countries'
                => 'json:' . __DIR__ . '/../zrcms-component.json',
            ],
        ];
    }
}
