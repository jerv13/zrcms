<?php

namespace Zrcms\Core\Uri\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Uri
{
    const SCHEMA = 'zrcms:site:{{siteId}}:{{type}}/{{path}}';

    public function getSiteId(): string;

    public function getType(): string;

    public function getPath(): string;
}
