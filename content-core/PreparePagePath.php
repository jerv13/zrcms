<?php

namespace Zrcms\ContentCore;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PreparePagePath
{
    /**
     * @todo @BC This would not be need if data was stored correctly
     * @param $pagePath
     *
     * @return string
     */
    public static function clean(
        $pagePath
    )
    {
        $pagePath = (string) $pagePath;

        return ltrim($pagePath, '/');
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ServerRequestInterface
     */
    public static function alias(ServerRequestInterface $request)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        if ($path === '/') {
            $path = '/index';
            $request = $request->withUri($uri->withPath($path));
        }

        return $request;
    }

}
