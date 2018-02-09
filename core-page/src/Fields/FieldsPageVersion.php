<?php

namespace Zrcms\CorePage\Fields;

use Reliv\FieldRat\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPageVersion extends FieldsPage implements Fields
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const PATH = 'path';

    /** For Drafts */
    const PAGE_CMS_RESOURCE_ID = 'pageCmsResourceId';
}
