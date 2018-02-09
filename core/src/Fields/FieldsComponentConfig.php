<?php

namespace Zrcms\Core\Fields;

use Zrcms\Core\Model\TrackableProperties;
use Reliv\FieldRat\Model\Fields;
use Reliv\FieldRat\Model\FieldsAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponentConfig extends FieldsAbstract implements Fields
{
    const TYPE = 'type';
    const NAME = 'name';
    const CONFIG_URI = 'configUri';
    const MODULE_DIRECTORY = 'moduleDirectory';
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
    const CREATED_DATE = TrackableProperties::CREATED_DATE;
    const COMPONENT_CONFIG_READER = FieldsComponent::COMPONENT_CONFIG_READER;
    const COMPONENT_CLASS = FieldsComponent::COMPONENT_CLASS;

    const DEFAULT_TYPE = 'basic';
}
