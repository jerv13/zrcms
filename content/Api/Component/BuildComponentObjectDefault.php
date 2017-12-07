<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Api\GetTypeValue;
use Zrcms\Content\Fields\FieldsComponent;
use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentBasic;
use Zrcms\Content\Model\Trackable;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectDefault implements BuildComponentObject
{
    const SERVICE_ALIAS = 'default';

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
    ): Component
    {
        $type = Param::getString(
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
        $componentClass = Param::get(
            $componentConfig,
            FieldsComponent::COMPONENT_CLASS,
            $defaultComponentClass
        );

        $this->assertValidClass($componentClass, $defaultComponentInterface);

        $moduleDirectory = Param::getRequired(
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
            Param::get(
                $componentConfig,
                FieldsComponentConfig::TYPE,
                FieldsComponentConfig::DEFAULT_TYPE
            ),
            Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::NAME
            ),
            Param::getRequired(
                $componentConfig,
                FieldsComponentConfig::CONFIG_LOCATION
            ),
            $moduleDirectoryReal,
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
            ),
            Param::get(
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
