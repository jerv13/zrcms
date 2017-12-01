<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFile extends ReadComponentConfigJsonFileAbstract implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'json';
    /**
     * @param string $jsonFileName
     */
    public function __construct(string $jsonFileName)
    {
        parent::__construct($jsonFileName);
    }
}
