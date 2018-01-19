<?php

namespace Zrcms\Http\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildMessageValue
{
    const DEFAULT_TYPE = BuildMessageKey::DEFAULT_TYPE;
    const DEFAULT_SOURCE = BuildMessageKey::DEFAULT_SOURCE;

    /**
     * @param string      $code    A failure code relating to this message
     * @param string      $message Client friendly/safe message
     * @param string      $type    The type or Category of the message
     * @param string|null $source  The source field or identifier for this message
     * @param array       $params  Extra params that may be used in translation or message parsing
     *
     * @return array
     */
    public static function invoke(
        string $code,
        string $message,
        string $type = self::DEFAULT_TYPE,
        string $source = self::DEFAULT_SOURCE,
        array $params = []
    ): array {
        return [
            'code' => $code,
            'message' => $message,
            'type' => $type,
            'source' => $source,
            'params' => $params,
            'key' => BuildMessageKey::invoke(
                $code,
                $type,
                $source
            ),
        ];
    }

    /**
     * @param string    $code
     * @param string    $message
     * @param string    $type
     * @param string    $source
     * @param array     $params
     *
     * @return array
     */
    public function __invoke(
        string $code,
        string $message,
        string $type = self::DEFAULT_TYPE,
        string $source = self::DEFAULT_SOURCE,
        array $params = []
    ): array {
        return static::invoke(
            $code,
            $message,
            $type,
            $source,
            $params
        );
    }
}
