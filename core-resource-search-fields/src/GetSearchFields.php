<?php

namespace Zrcms\CoreResourceSearchFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSearchFields
{
    /**
     * @param string $resourceClass
     *
     * @return array|null
     */
    public function __invoke(string $resourceClass);
}
