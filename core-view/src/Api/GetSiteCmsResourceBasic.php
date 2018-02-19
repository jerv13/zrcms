<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreView\Exception\SiteNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteCmsResourceBasic implements GetSiteCmsResource
{
    protected $findSiteCmsResourceByHost;

    /**
     * @param FindSiteCmsResourceByHost $findSiteCmsResourceByHost
     */
    public function __construct(
        FindSiteCmsResourceByHost $findSiteCmsResourceByHost
    ) {
        $this->findSiteCmsResourceByHost = $findSiteCmsResourceByHost;
    }

    /**
     * @param string    $host
     * @param bool|null $published
     *
     * @return SiteCmsResource
     * @throws SiteNotFound
     */
    public function __invoke(
        string $host,
        $published = true
    ): SiteCmsResource {
        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $host
        );

        if (empty($siteCmsResource)) {
            throw new SiteNotFound(
                'Site not found for host: (' . $host . ')'
            );
        }

        return $siteCmsResource;
    }
}
