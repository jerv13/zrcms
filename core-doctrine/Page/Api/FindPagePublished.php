<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Zrcms\Core\Page\Model\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPagePublished implements \Zrcms\Core\Page\Api\FindPagePublished
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
    ) {

    }
}
