<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\Trackable;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectByType implements BuildComponentObject
{
    const SERVICE_ALIAS = 'basic';

    protected $getTypeValue;
    protected $defaultComponentClass;

    /**
     * @param GetTypeValue $getTypeValue
     * @param string       $defaultComponentClass
     */
    public function __construct(
        GetTypeValue $getTypeValue,
        string $defaultComponentClass = ComponentBasic::class
    ) {
        $this->getTypeValue = $getTypeValue;
        $this->defaultComponentClass = $defaultComponentClass;
    }

    /**
     * @param array $componentConfig
     * @param array $options
     *
     * @return Component
     * @throws \Exception
     */
    public function __invoke(
        array $componentConfig,
        array $options = []
    ): Component {
        $type = Property::getString(
            $componentConfig,
            FieldsComponentConfig::TYPE,
            FieldsComponentConfig::DEFAULT_TYPE
        );

        $defaultComponentClass = $this->getTypeValue->__invoke(
            $type,
            'component-model-class',
            $this->defaultComponentClass
        );

        $defaultComponentInterface = $this->getTypeValue->__invoke(
            $type,
            'component-model-interface',
            Component::class
        );

        // Components might have special classes from config
        /** @var Component::class $componentClass */
        $componentClass = Property::get(
            $componentConfig,
            FieldsComponent::COMPONENT_CLASS,
            $defaultComponentClass
        );

        $this->assertValidClass($componentClass, $defaultComponentInterface);

        $moduleDirectory = Property::getRequired(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $moduleDirectoryReal = realpath($moduleDirectory);

        if ($moduleDirectoryReal === false) {
            throw new \Exception(
                'Module directory is not valid: (' . $moduleDirectory . ')'
            );
        }

        return new $componentClass(
            Property::get(
                $componentConfig,
                FieldsComponentConfig::TYPE,
                FieldsComponentConfig::DEFAULT_TYPE
            ),
            Property::getRequired(
                $componentConfig,
                FieldsComponentConfig::NAME
            ),
            Property::getRequired(
                $componentConfig,
                FieldsComponentConfig::CONFIG_URI
            ),
            $moduleDirectoryReal,
            $componentConfig,
            Property::get(
                $componentConfig,
                FieldsComponentConfig::CREATED_BY_USER_ID,
                Trackable::UNKNOWN_USER_ID
            ),
            Property::get(
                $componentConfig,
                FieldsComponentConfig::CREATED_REASON,
                Trackable::UNKNOWN_REASON
            ),
            Property::get(
                $componentConfig,
                FieldsComponentConfig::CREATED_DATE,
                null
            )
        );
    }

    /**
     * @param string $componentClass
     * @param string $defaultComponentInterface
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidClass(
        string $componentClass,
        string $defaultComponentInterface = Component::class
    ) {
        if (!is_a($componentClass, $defaultComponentInterface, true)) {
            throw new \Exception(
                $componentClass . ' must be a ' . Component::class
            );
        }
    }
}
