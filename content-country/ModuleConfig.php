<?php

namespace Zrcms\ContentCountry;

use Zrcms\ContentCore\ApiNoop;
use Zrcms\ContentCountry\Api\Action\PublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Action\UnpublishCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResource;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourceByIso3;
use Zrcms\ContentCountry\Api\Repository\FindCountryCmsResourcesBy;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersion;
use Zrcms\ContentCountry\Api\Repository\FindCountryVersionsBy;
use Zrcms\ContentCountry\Api\Repository\InsertCountryVersion;

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
            'dependencies' => [
                'zrcms-components' => [
                    'countries' => [

                    ]
                ]
            ],
        ];
    }
}
