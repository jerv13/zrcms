<?php

namespace Zrcms\Json;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Json
{
    /**
     * @param mixed  $value
     * @param int    $options
     * @param int    $depth
     * @param string $errorMessage
     *
     * @return string
     */
    public static function encode(
        $value,
        $options = 0,
        $depth = 512,
        $errorMessage = ''
    ): string {
        // Clear json_last_error()
        json_encode(null);

        $json = json_encode($value, $options, $depth);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unable to encode data to JSON: %s. %s',
                    json_last_error_msg(),
                    $errorMessage
                )
            );
        }

        return $json;
    }

    /**
     * @param string $json
     * @param bool   $assoc
     * @param int    $depth
     * @param int    $options
     * @param string $errorMessage
     *
     * @return mixed
     */
    public static function decode(
        string $json,
        $assoc = false,
        $depth = 512,
        $options = 0,
        $errorMessage = ''
    ) {
        // Clear json_last_error()
        json_encode(null);

        $value = json_decode($json, $assoc, $depth, $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unable to decode JSON: %s. %s',
                    json_last_error_msg(),
                    $errorMessage
                )
            );
        }

        return $value;
    }
}
