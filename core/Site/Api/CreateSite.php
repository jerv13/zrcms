<?php

namespace Zrcms\Core\Site\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreateSite
{
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    );
}
