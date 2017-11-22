<?php

namespace Zrcms\Http\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsValidContentType
{
    /**
     * @todo Optimize me
     *
     * @param ResponseInterface $response
     * @param array             $validContentTypes
     *
     * @return bool
     */
    public static function invoke(
        ResponseInterface $response,
        array $validContentTypes
    ): bool {
        $contentTypeLine = $response->getHeaderLine('content-type');

        $parts = explode(',', $contentTypeLine);

        foreach ($parts as $part) {
            $subParts = explode(';', $part);
            foreach ($subParts as $subPart) {
                if (in_array($subPart, $validContentTypes)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param ResponseInterface $response
     * @param array             $validContentTypes
     *
     * @return bool
     */
    public function __invoke(
        ResponseInterface $response,
        array $validContentTypes
    ): bool {
        return self::invoke(
            $response,
            $validContentTypes
        );
    }
}
