<?php

namespace Zrcms\ContentCore\Site\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceVersion;
use Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository\FindSiteCmsResourceVersionByHost;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteCmsResourceVersionByRequest
{
    /**
     * @var FindSiteCmsResourceVersionByHost
     */
    protected $findSiteCmsResourceVersionByHost;

    /**
     * @todo Implement an expiration for long running services
     *
     * @var array
     */
    protected $cache = [];

    /**
     * @param FindSiteCmsResourceVersionByHost $findSiteCmsResourceVersionByHost
     */
    public function __construct(
        FindSiteCmsResourceVersionByHost $findSiteCmsResourceVersionByHost
    ) {
        $this->findSiteCmsResourceVersionByHost = $findSiteCmsResourceVersionByHost;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return SiteCmsResourceVersion|CmsResourceVersion|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ) {
        $uri = $request->getUri();
        $host = $uri->getHost();

        // basic caching
        if (array_key_exists($host, $this->cache)) {
            return $this->cache[$host];
        }

        $siteCmsResourceVersion = $this->findSiteCmsResourceVersionByHost->__invoke(
            $host
        );

        $this->cache[$host] = $siteCmsResourceVersion;

        return $siteCmsResourceVersion;
    }
}
