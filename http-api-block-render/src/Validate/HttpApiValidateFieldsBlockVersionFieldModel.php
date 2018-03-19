<?php

namespace Zrcms\HttpApiBlockRender\Validate;

use Reliv\FieldRat\Api\FieldValidator\ValidateFieldsByFieldsModelName;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;
use Zrcms\HttpApi\Validate\HttpApiValidateFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateFieldsBlockVersionFieldModel extends HttpApiValidateFields
{
    /**
     * @param ValidateFieldsByFieldsModelName $validateFields
     * @param int                             $notValidStatus
     * @param bool                            $debug
     */
    public function __construct(
        ValidateFieldsByFieldsModelName $validateFields,
        int $notValidStatus = 400,
        bool $debug = false
    ) {
        parent::__construct(
            $validateFields,
            [ValidateFieldsByFieldsModelName::OPTION_FIELDS_MODEL_NAME => FieldsBlockVersion::FIELD_MODEL_NAME],
            $notValidStatus,
            $debug
        );
    }
}
