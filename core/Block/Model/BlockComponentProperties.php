<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Content\Model\ComponentProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockComponentProperties
{
    // required
    const NAME = ComponentProperties::NAME;
    const DIRECTORY = ComponentProperties::DIRECTORY;
    const DEFAULT_CONFIG = 'defaultConfig';
    const CACHEABLE = 'cache';

    // @todo const RENDER_DATA_GETTER = 'renderDataService';
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
