<?php

namespace Zrcms\CoreApplication\Api;

use Zrcms\Core\Api\GetTypeValue;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTypeValueBasic implements GetTypeValue
{
    protected $typesConfig;

    /**
     * @param array $typesConfig
     */
    public function __construct(
        array $typesConfig
    ) {
        $this->typesConfig = $typesConfig;
    }

    /**
     * @param string $type
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function __invoke(
        string $type,
        string $key,
        $default = null
    ) {
        $typeConfig = Property::getArray(
            $this->typesConfig,
            $type,
            []
        );

        return Property::get(
            $typeConfig,
            $key,
            $default
        );
    }
}
