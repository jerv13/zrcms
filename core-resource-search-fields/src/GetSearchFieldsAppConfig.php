<?php

namespace Zrcms\CoreResourceSearchFields;

use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSearchFieldsAppConfig implements GetSearchFields
{
    protected $searchFieldsConfig;

    /**
     * @param array $searchFieldsConfig
     */
    public function __construct(
        array $searchFieldsConfig
    ) {
        $this->searchFieldsConfig = $searchFieldsConfig;
    }

    /**
     * @param string $resourceClass
     *
     * @return array|null
     * @throws \Exception
     */
    public function __invoke(string $resourceClass)
    {
        return Property::getArray(
            $this->searchFieldsConfig,
            $resourceClass,
            null
        );
    }
}
