<?php

namespace Zrcms\ContentRedirect\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceVersion;

/**
 * Find published CmsResource by site and request path
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface FindRedirectCmsResourceVersionBySiteRequestPath
{
    /**
     * @param string $siteCmsResourceId
     * @param string $requestPath
     * @param array  $options
     *
     * @return RedirectCmsResourceVersion|null
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $requestPath,
        array $options = []
    );
}
