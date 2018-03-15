<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Dynamic
{
    const ROUTE_OPTION_ZRCMS_API = 'zrcms-api';
    const ROUTE_OPTION_ZRCMS_IMPLEMENTATION = 'zrcms-implementation';
    const ATTRIBUTE_ZRCMS_IMPLEMENTATION = 'zrcms-implementation';
    const ATTRIBUTE_ZRCMS_API = 'zrcms-api';
    const ATTRIBUTE_DYNAMIC_API_CONFIG = 'zrcms-dynamic-api-config';
    const ATTRIBUTE_DYNAMIC_API_TYPE = 'zrcms-dynamic-api-type';

    const ATTRIBUTE_ZRCMS_ID = 'id';

    const MIDDLEWARE_NAME_ACL = 'acl';

    const MIDDLEWARE_NAME_VALIDATE_ID = 'validate-id';
    const MIDDLEWARE_NAME_VALIDATE_PARAM_QUERY = 'validate-param-query';
    const MIDDLEWARE_NAME_FIELDS_VALIDATOR = 'fields-validator';

    const MIDDLEWARE_PARAM_QUERY = 'param-query';

    const MIDDLEWARE_NAME_API = 'api';
}
