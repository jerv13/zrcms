<?php

namespace Zrcms\Http\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RequestAttributes
{
    const QUERY_WHERE = 'zrcms-query-where';
    const QUERY_ORDER_BY = 'zrcms-query-order-by';
    const QUERY_LIMIT = 'zrcms-query-limit';
    const QUERY_OFFSET = 'zrcms-query-offset';
}
