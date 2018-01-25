<?php

namespace Zrcms\Fields\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Fields
{
    /**
     * @param string $name
     *
     * @return Field
     */
    public function findField(string $name): Field;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool;

    /**
     * @return array ['{name}' => {default}]
     */
    public function getFieldDefaults(): array;

    /**
     * @return array
     */
    public function getDefaultFieldsConfig(): array;

    /**
     * @return array
     */
    public function getFieldsConfig(): array;

    /**
     * @param array $fieldValues ['{field-name}' => {fieldValue}]
     *
     * @return array ['{field-name}' => {fieldValue}]
     */
    public function validFieldValues(array $fieldValues): array;

    /**
     * @return Field[]
     */
    public function __toArray(): array;
}
