<?php

namespace Zrcms\CoreBlock\Fields;

use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsBlockComponent extends FieldsComponent implements Fields
{
    // required
    const DEFAULT_CONFIG = 'defaultConfig';
    const CACHEABLE = 'cache';

    const RENDERER = 'renderer';
    const DATA_PROVIDER = 'data-provider';
    const FIELDS = 'fields';
    const TEMPLATE_FILE = 'templateFile';

    // client only
    const ICON = 'icon';
    const EDITOR = 'editor';
    const CATEGORY = 'category';
    const LABEL = 'label';
    const DESCRIPTION = 'description';
}
