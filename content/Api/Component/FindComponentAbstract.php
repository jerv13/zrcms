<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindComponentAbstract implements FindComponent
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
     * @param string $name
     * @param array  $options
     *
     * @return Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $components = $this->getRegisterComponents->__invoke();

        $result = $this->searchComponentList->__invoke(
            $components,
            [FieldsComponentConfig::NAME => $name]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
