<?php

namespace Zrcms\Core\Fields;

use Reliv\FieldRat\Model\Fields;
use Reliv\FieldRat\Model\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponent extends FieldsAbstract implements Fields
{
    const FIELD_MODEL_NAME = 'component';

    const COMPONENT_CONFIG_READER = 'componentConfigReader';
    const COMPONENT_CLASS = 'componentClass';
    const JAVASCRIPT = 'js';
    const CSS = 'css';
}
