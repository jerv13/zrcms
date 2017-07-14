<?php

namespace Zrcms\ContentResourceUri\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Uri
{
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
