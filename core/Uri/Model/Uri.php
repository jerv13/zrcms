<?php

namespace Zrcms\Core\Uri\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Uri
{
    const SCHEMA = 'zrcms:site:{{siteId}}:{{type}}/{{path}}';

    /**
     * @return string
     */
    public function getSiteId(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getSchema(): string;
}
