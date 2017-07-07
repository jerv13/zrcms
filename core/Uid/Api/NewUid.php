<?php

namespace Zrcms\Core\Uid\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface NewUid
{
    /**
     * Unique identifier
     *
     * @param array $options
     *
     * @return string
     */
    public function __invoke(array $options = []);
}
