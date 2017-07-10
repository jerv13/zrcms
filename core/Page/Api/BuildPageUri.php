<?php

namespace Zrcms\Core\Page\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildPageUri
{
    /**
     * @param int    $siteId
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $path,
        array $options = []
    ): string;
}
