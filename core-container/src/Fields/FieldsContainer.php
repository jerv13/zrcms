<?php

namespace Zrcms\CoreContainer\Fields;

use Zrcms\Core\Fields\FieldsContent;
use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsContainer extends FieldsContent implements Fields
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDERER = 'renderer';
    const BLOCK_VERSIONS = 'blockVersions';

    const DEFAULT_RENDER_TAGS_GETTER = 'blocks';
    const DEFAULT_RENDERER = 'rows';
    const DEFAULT_BLOCK_VERSIONS = [];
}
