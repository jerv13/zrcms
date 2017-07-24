<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetConfigComponents
{
    /**
     * @param array $options
     *
     * @return Component[]
     */
    public function __invoke(
        array $options = []
    ): array;
}
