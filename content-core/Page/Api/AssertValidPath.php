<?php

namespace Zrcms\ContentCore\Page\Api;

use Zrcms\ContentCore\Page\Exception\InvalidPath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidPath
{
    /**
     * @param string $path
     *
     * @return void
     * @throws InvalidPath
     */
    public static function invoke(
        string $path
    ) {
        if (substr($path, 0, 1) !== "/") {
            throw new InvalidPath(
                'Path for page must start with /'
                . ' got: ' . $path
            );
        }
    }
}
