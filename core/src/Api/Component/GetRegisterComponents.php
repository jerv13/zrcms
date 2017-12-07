<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetRegisterComponents
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
