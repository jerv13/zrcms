<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface TrackableModifyProperties extends TrackableProperties
{
    const MODIFIED_BY_USER_ID = 'modifiedByUserId';
    const MODIFIED_REASON = 'modifiedReason';
    const MODIFIED_DATE = 'modifiedDate';
    const MODIFIED_DATE_STRING = 'modifiedDateString';
}
