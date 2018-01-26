<?php

namespace Zrcms\Core\Fields;

use Zrcms\Fields\Model\Fields;
use Zrcms\Fields\Model\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponent extends FieldsAbstract implements Fields
{
    const COMPONENT_CONFIG_READER = 'componentConfigReader';
    const COMPONENT_CLASS = 'componentClass';
    const JAVASCRIPT = 'js';
    const CSS = 'css';
}
