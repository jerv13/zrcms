<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Fields\FieldsComponent;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentBasic;
use Zrcms\Content\Model\Trackable;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BuildComponentObjectAbstract
{
    protected $defaultComponentClass;

    /**
     * @param string $defaultComponentClass
     */
    public function __construct(
        string $defaultComponentClass = ComponentBasic::class
    ) {
        $this->defaultComponentClass = $defaultComponentClass;
    }

    /**
     * @param array $componentConfig
     * @param array $options
     *
     * @return Component
     */
    public function __invoke(
        array $componentConfig,
        array $options = []
    ): Component {
        // Components might have special classes
        /** @var Component::class $componentClass */
        $componentClass = Param::get(
            $componentConfig,
            FieldsComponent::COMPONENT_CLASS,
            $this->defaultComponentClass
        );

        $this->assertValidClass($componentClass);

        return new $componentClass(
            Param::get(
                $componentConfig,
                FieldsComponentConfig::CATEGORY,
                FieldsComponentConfig::DEFAULT_CATEGORY
            ),
            Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::NAME
            ),
            Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::CONFIG_LOCATION
            ),
            $componentConfig,
            Param::get(
                $componentConfig,
                FieldsComponentConfig::CREATED_BY_USER_ID,
                Trackable::UNKNOWN_USER_ID
            ),
            Param::get(
                $componentConfig,
                FieldsComponentConfig::CREATED_REASON,
                Trackable::UNKNOWN_REASON
            )
        );
    }

    /**
     * @param string $componentClass
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidClass(
        string $componentClass
    ) {
        if (!is_a($componentClass, Component::class, true)) {
            throw new \Exception(
                $componentClass . ' must be a ' . Component::class
            );
        }
    }
}
