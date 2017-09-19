<?php

namespace Zrcms\Content\Fields;

use Zrcms\Content\Exception\FieldMissing;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsAbstract
{
    /**
     * [
     *  'name' => self::FIELD_NAME,
     *  'type' => 'text',
     *  'label' => 'Name',
     *  'required' => false,
     *  'validator' => '{service}',
     *  'default' => '',
     *  'options' => [
     *  ],
     * ],
     *
     * @var array
     */
    protected $defaultFieldsConfig = [];

    /**
     * @var array
     */
    protected $fieldsConfig = [];

    /**
     * @var array
     */
    protected $fieldsNameIndex = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @param array $fieldsConfig
     */
    public function __construct(array $fieldsConfig)
    {
        $defaultFieldsConfig = $this->getDefaultFieldsConfig();
        // Default config
        foreach ($defaultFieldsConfig as $fieldConfig) {
            $field = FieldBasic::build($fieldConfig);
            $this->addField($field);
        }

        $fieldsArray = [];

        foreach ($fieldsConfig as $fieldConfig) {
            $field = FieldBasic::build($fieldConfig);
            $fieldsArray[] = $field;
        }

        foreach ($fieldsArray as $field) {
            $this->addField($field);
        }

        $this->fieldsConfig = array_merge($fieldsConfig, $defaultFieldsConfig);
    }

    /**
     * @param string $name
     *
     * @return Field
     */
    public function getField(string $name): Field
    {
        if ($this->hasField($name)) {
            return $this->fields[$this->fieldsNameIndex[$name]];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool
    {
        return array_key_exists($name, $this->fieldsNameIndex);
    }

    /**
     * @return array ['{name}' => {default}]
     */
    public function getFieldDefaults(): array
    {
        $defaults = [];
        /** @var Field $field */
        foreach ($this->fields as $field) {
            $defaults[$field->getName()] = $field->getDefault();
        }

        return $defaults;
    }

    /**
     * @return array
     */
    public function getDefaultFieldsConfig(): array
    {
        return $this->defaultFieldsConfig;
    }

    /**
     * @return array
     */
    public function getFieldsConfig(): array
    {
        return $this->fieldsConfig;
    }

    /**
     * @param array $fieldValues ['{field-name}' => {fieldValue}]
     *
     * @return array ['{field-name}' => {fieldValue}]
     */
    public function validFieldValues(array $fieldValues): array
    {
        $values = [];
        /** @var Field $field */
        foreach ($this->fields as $field) {
            $name = $field->getName();
            if ($field->isRequired()) {
                Param::assertHas(
                    $fieldValues,
                    $name,
                    FieldMissing::buildThrower(
                        $name,
                        $fieldValues,
                        get_class($this)
                    )
                );
            }

            // @todo Can force types
            $values[$field->getName()] = Param::get($fieldValues, $field->getName(), $field->getDefault());
        }

        return $values;
    }

    /**
     * @return Field[]
     */
    public function __toArray(): array
    {
        return $this->fields;
    }

    /**
     * @param Field $field
     *
     * @return void
     * @throws \Exception
     */
    protected function addField(Field $field)
    {
        if ($this->hasField($field->getName())) {
            throw new \Exception(
                'Field already defined for name: ' . $field->getName()
            );
        }

        $index = count($this->fields);

        $this->fieldsNameIndex[$index] = $field->getName();
        $this->fields[] = $field;
    }
}
