<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Repository;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindContent implements \Zrcms\ContentVersionControl\Api\Repository\FindContent
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Content|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    ){

    }
}
