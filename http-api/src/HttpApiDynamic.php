<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HttpApiDynamic
{
    const ROUTE_OPTION_ZRCMS_API = 'zrcms-api';
    const ATTRIBUTE_ZRCMS_IMPLEMENTATION = 'zrcms-implementation';
    const ATTRIBUTE_ZRCMS_ID = 'id';

    const MIDDLEWARE_NAME_ACL = 'acl';

    const MIDDLEWARE_NAME_VALIDATE_ID = 'validate-id';
    const MIDDLEWARE_NAME_VALIDATE_PARAM_QUERY = 'validate-param-query';
    const MIDDLEWARE_NAME_VALIDATE_DATA = 'validate-data';

    const MIDDLEWARE_PARAM_QUERY = 'param-query';

    const MIDDLEWARE_NAME_API = 'api';
}
