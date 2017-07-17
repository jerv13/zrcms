<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\Content\Api\Repository\FindContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Site\Model\Site;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSite extends FindContent
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return Site|Content|null
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
