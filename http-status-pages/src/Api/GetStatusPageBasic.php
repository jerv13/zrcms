<?php

namespace Zrcms\HttpStatusPages\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpStatusPages\Model\HttpStatusPagesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusPageBasic implements GetStatusPage
{
    /**
     * @var GetSiteCmsResourceByRequest
     */
    protected $getSiteCmsResourceByRequest;

    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param FindComponent          $findComponent
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        FindComponent $findComponent
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->findComponent = $findComponent;
    }

    /**
     * @param ServerRequestInterface $request
     * @param int                    $status
     *
     * @return null|string
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        ServerRequestInterface $request,
        int $status
    ) {
        $status = (string)$status;

        /** @var HttpStatusPagesComponent $component */
        $component = $this->findComponent->__invoke(
            'basic',
            HttpStatusPagesComponent::NAME
        );

        $statusPage = $component->findStatusPage($status);

        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke($request);

        // Try to get the $statusPage from site
        if (!empty($siteCmsResource)) {
            $siteVersion = $siteCmsResource->getContentVersion();
            $statusPage = $siteVersion->findStatusPage(
                $status,
                $statusPage
            );
        }

        return $statusPage;
    }
}
