<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponentBasic implements FindComponent
{
    /**
     * @var GetRegisterComponents
     */
    protected $getRegisterComponents;

    /**
     * @var SearchComponentListBasic
     */
    protected $searchComponentList;

    /**
     * @param GetRegisterComponents $getRegisterComponents
     * @param SearchComponentList   $searchComponentList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchComponentList $searchComponentList
    ) {
        $this->getRegisterComponents = $getRegisterComponents;
        $this->searchComponentList = $searchComponentList;
    }

    /**
     * @param string $type
     * @param string $name
     * @param array  $options
     *
     * @return Component|null
     */
    public function __invoke(
        string $type,
        string $name,
        array $options = []
    ) {
        $components = $this->getRegisterComponents->__invoke();

        $result = $this->searchComponentList->__invoke(
            $components,
            [
                FieldsComponentConfig::TYPE => $type,
                FieldsComponentConfig::NAME => $name
            ]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
