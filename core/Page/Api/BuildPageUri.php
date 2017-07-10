<?php

namespace Zrcms\Core\Page\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildPageUri
{
    /**
     * @param int    $siteId
     * @param string $pagePath
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $pagePath,
        array $options = []
    ): string;
}
