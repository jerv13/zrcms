<?php

namespace Zrcms\ContentResourceUri\Schema;

class UriSchemaThemeLayout
{
    const SCHEMA = 'zrcms:theme-layout/{{theme}}/{{layout}}';
    const SCHEMA_REGEX = 'zrcms\:theme-layout\/(?<theme>[^\/]+)\/(?<layout>.*)';
}
