<?php

namespace Zrcms\Fields\Api\Field;

use Zrcms\Fields\Model\Fields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindFieldsByModelBasic implements FindFieldsByModel
{
    protected $fieldsModelConfig;
    protected $fieldsModelFieldsConfig;

    /**
     * @param array $fieldsModelConfig
     * @param array $fieldsModelFieldsConfig
     */
    public function __construct(
        array $fieldsModelConfig,
        array $fieldsModelFieldsConfig
    ) {
        $this->fieldsModelConfig = $fieldsModelConfig;
        $this->fieldsModelFieldsConfig = $fieldsModelFieldsConfig;
    }

    /**
     * @param string $model
     * @param array  $options
     *
     * @return null|string|Fields
     * @throws \Exception
     */
    public function __invoke(
        string $model,
        array $options = []
    ) {
        $fieldsModel = Param::getString(
            $this->fieldsModelConfig,
            $model
        );

        if (empty($fieldsModel)) {
            return null;
        }

        $fieldsConfig = Param::getArray(
            $this->fieldsModelFieldsConfig,
            $model,
            []
        );

        /** @var Fields $fields */
        $fields = new $fieldsModel($fieldsConfig);

        if (!$fields instanceof Fields) {
            throw new \Exception(
                'Fields model: (' . $model . ')'
                . ' must be instance of: (' . Fields::class . ')'
                . ' got ' . $fieldsModel
            );
        }

        return $fields;
    }
}
