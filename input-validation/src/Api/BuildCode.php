<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildCode
{
    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid';
    const DEFAULT_VALID_CODE = '';

    /**
     * @param bool   $valid
     * @param array  $options
     * @param string $defaultInvalidCode
     * @param string $validCode
     *
     * @return string
     */
    public static function invoke(
        bool $valid,
        array $options = [],
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE,
        string $validCode = self::DEFAULT_VALID_CODE
    ): string {
        if ($valid) {
            return $validCode;
        };

        return Param::getString(
            $options,
            static::OPTION_INVALID_CODE,
            $defaultInvalidCode
        );
    }

    /**
     * @param bool   $valid
     * @param array  $options
     * @param string $defaultInvalidCode
     * @param string $validCode
     *
     * @return string
     */
    public function __invoke(
        bool $valid,
        array $options = [],
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE,
        string $validCode = self::DEFAULT_VALID_CODE
    ): string {
        return self::invoke(
            $valid,
            $options,
            $defaultInvalidCode,
            $validCode
        );
    }
}
