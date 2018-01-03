<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreView\Exception\PageNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageCmsResourceBasic implements GetPageCmsResource
{
    protected $findPageCmsResourceBySitePath;

    /**
     * @param FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath
     */
    public function __construct(
        FindPageCmsResourceBySitePath $findPageCmsResourceBySitePath
    ) {
        $this->findPageCmsResourceBySitePath = $findPageCmsResourceBySitePath;
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $path
     *
     * @return PageCmsResource
     * @throws PageNotFound
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $path
    ): PageCmsResource {
        /** @var PageCmsResource $pageCmsResource */
        $pageCmsResource = $this->findPageCmsResourceBySitePath->__invoke(
            $siteCmsResourceId,
            $path
        );

        if (empty($pageCmsResource)) {
            throw new PageNotFound(
                'Page not found for site: (' . $siteCmsResourceId . ')'
                . ' and page: (' . $path . ')'
            );
        }

        return $pageCmsResource;
    }
}
