<?php

namespace Zrcms\ContentCore\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageTemplateCmsResource extends PageContainerCmsResource
{
    /**
     * PageContainerVersion::id
     *
     * @return string
     */
    public function getContentVersionId(): string;
}
