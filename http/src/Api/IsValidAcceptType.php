<?php

namespace Zrcms\Http\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsValidAcceptType
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $validAcceptTypes
     *
     * @return bool
     */
    public static function invoke(
        ServerRequestInterface $request,
        array $validAcceptTypes
    ): bool {
        $contentTypeLine = $request->getHeaderLine('accept');

        $parts = explode(',', $contentTypeLine);

        foreach ($parts as $part) {
            $subParts = explode(';', $part);
            foreach ($subParts as $subPart) {
                if (in_array($subPart, $validAcceptTypes)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $validAcceptTypes
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $validAcceptTypes
    ): bool {
        return self::invoke(
            $request,
            $validAcceptTypes
        );
    }
}
