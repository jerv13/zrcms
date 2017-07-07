<?php

namespace Zrcms\Core\Page\Api;

use Zrcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPagePublished
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return PagePublished|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
