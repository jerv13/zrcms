<?php

namespace Zrcms\ViewHead\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesHeadSection extends \Zrcms\Content\Model\PropertiesContent
{
    const TAG = 'tag';
    const SECTIONS = 'sections';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
        ];
}
