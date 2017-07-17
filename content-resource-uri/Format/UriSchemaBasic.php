<?php

namespace Zrcms\ContentResourceUri\Schema;

class CmsUriSchemaBasic
{
    const SCHEMA = 'zrcms:site:{{siteId}}:{{type}}/{{path}}';
    const SCHEMA_REGEX = 'zrcms\:site\:(?<siteId>[^\:]+)\:(?<type>[^\/]+)\/(?<path>.*)';
}
