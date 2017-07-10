<?php

namespace Zrcms\Core\Uri\Schema;

class UriSchemaBasic
{
    const SCHEMA = 'zrcms:site:{{siteId}}:{{type}}/{{path}}';
    const SCHEMA_REGEX = 'zrcms\:site\:(?<siteId>[^\:]+)\:(?<type>[^\/]+)\/(?<path>.*)';
}
