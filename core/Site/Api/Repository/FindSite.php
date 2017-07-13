<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\ContentVersionControl\Api\Repository\FindContent;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSite extends FindContent
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return SitePublished|Content|null
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
