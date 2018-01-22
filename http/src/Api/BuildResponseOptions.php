<?php

namespace Zrcms\Http\Api;

use Zrcms\Debug\IsDebug;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildResponseOptions
{
    /**
     * @return bool
     */
    protected static function isDebug(): bool
    {
        $isDebug = false;

        try {
            $isDebug = IsDebug::invoke();
        } catch (\Throwable $error) {
            // do nothing
        }

        return $isDebug;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public static function invoke(array $options = []): array
    {
        $responseOptions = [];

        $jsonFlags = Param::get(
            $options,
            ZrcmsJsonResponse::OPTION_JSON_FLAGS,
            ZrcmsJsonResponse::DEFAULT_JSON_FLAGS
        );

        if (self::isDebug()) {
            $jsonFlags = JSON_PRETTY_PRINT | $jsonFlags;
        }

        $responseOptions[ZrcmsJsonResponse::OPTION_JSON_FLAGS] = $jsonFlags;

        return $responseOptions;
    }
}
