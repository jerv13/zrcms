<?php

namespace Zrcms\ServiceAlias\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetServiceAliasRegistry
{
    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array;
}
