<?php

namespace Zrcms\ContentVersionControl\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Action
{
    const COPY_CONTENT_TO_CONTENT = 'CopyContentToContent';
    const COPY_CONTENT_TO_DRAFT = 'CopyContentToDraft';
    const CREATE_CONTENT = 'CreateContent';
    const CREATE_DRAFT = 'CreateDraft';
    const PUBLISH_DRAFT = 'PublishDraft';
    const PUBLISH_HISTORY = 'PublishHistory';
    const PUBLISH_DELETED = 'PublishDeleted';
    const UNPUBLISH_CONTENT = 'UnpublishContent';

    /**
     * @return string
     */
    public function getAction(): string;
}
