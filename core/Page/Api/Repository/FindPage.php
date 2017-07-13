<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\ContentVersionControl\Api\Repository\FindContent;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPage extends FindContent
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Page|Content|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
