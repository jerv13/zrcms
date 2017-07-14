<?php

namespace Zrcms\Core\Block\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockProperties
{
    const NAME = 'name';
    const DIRECTORY = 'directory';

    const CONFIG = 'config';
    const ICON = 'icon';
    const EDITOR = 'editor';
    const CATEGORY = 'category';
    const LABEL = 'label';
    const DESCRIPTION = 'description';
    const DATA_PROVIDER = 'data-provider';
    const FIELDS = 'fields';
    const CACHEABLE = 'cache';
    const RENDERER = 'renderer';
}
