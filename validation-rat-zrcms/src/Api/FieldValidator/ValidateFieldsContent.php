<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidateFieldsContent extends ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PROPERTIES = 'properties';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_FIELDS_VALIDATOR_PROPERTIES = 'fields-validator-properties';
    const OPTION_FIELDS_VALIDATOR_OPTIONS_PROPERTIES = 'fields-validator-options-properties';
}
