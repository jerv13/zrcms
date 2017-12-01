<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigPhpFile extends ReadComponentConfigPhpFileAbstract implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'php-file';

    /**
     * @param string $phpFileName
     */
    public function __construct(string $phpFileName)
    {
        parent::__construct($phpFileName);
    }
}
