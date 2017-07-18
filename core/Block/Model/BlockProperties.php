<?php

namespace Zrcms\Core\Block\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockProperties
{
    // required
    const NAME = 'name';
    const DIRECTORY = 'directory';
    const CONFIG = 'config';
    const CACHEABLE = 'cache';

    // possibly required
    const RENDERER = 'renderer';
    const DATA_PROVIDER = 'data-provider';
    const FIELDS = 'fields';

    // client only
    const ICON = 'icon';
    const EDITOR = 'editor';
    const CATEGORY = 'category';
    const LABEL = 'label';
    const DESCRIPTION = 'description';
}
