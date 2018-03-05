<?php

namespace Zrcms\CoreSite\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourceByHost;

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
     * @return mixed|null|CmsResource|SiteCmsResource
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
