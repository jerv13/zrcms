<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ValidationRat\Api\Validator\ValidateIsStringOrNull;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsCreateCmsResourceData extends ValidateFieldsUpdateCmsResourceData
{
    const DEFAULT_VALIDATOR_ID = ValidateIsStringOrNull::class;
    const DEFAULT_VALIDATOR_OPTIONS_ID = [];
}
