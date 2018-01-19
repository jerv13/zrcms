<?php

namespace Zrcms\Http\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildMessageKey
{
    const DEFAULT_TYPE = 'generic';
    const DEFAULT_SOURCE = 'unknown';

    /**
     * @param string      $code    A failure code relating to this message
     * @param string      $type    The type or Category of the message
     * @param string|null $source  The source field or identifier for this message
     *
     * @return string
     */
    public static function invoke(
        string $code,
        string $type = self::DEFAULT_TYPE,
        string $source = self::DEFAULT_SOURCE
    ): string {
        $key = str_replace('.', '-', $type);
        $key .= '.' . str_replace('.', '-', $source);
        $key .= '.' . str_replace('.', '-', $code);

        return $key;
    }

    /**
     * @param string    $code
     * @param string    $type
     * @param string    $source
     *
     * @return string
     */
    public function __invoke(
        string $code,
        string $type = self::DEFAULT_TYPE,
        string $source = self::DEFAULT_SOURCE
    ): string {
        return static::invoke(
            $code,
            $type,
            $source
        );
    }
}
