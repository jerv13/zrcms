<?php

namespace Zrcms\ContentCore\Site\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Site\Api\CmsResource\FindSiteCmsResourceByHost;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteCmsResourceByRequest
{
    /**
     * @var FindSiteCmsResourceByHost
     */
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
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return SiteCmsResource|CmsResource|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ) {
        $uri = $request->getUri();
        $host = $uri->getHost();

        $siteCmsResource = $this->findSiteCmsResourceByHost->__invoke(
            $host
        );

        return $siteCmsResource;
    }
}
