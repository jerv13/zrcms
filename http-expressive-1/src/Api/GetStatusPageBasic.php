<?php

namespace Zrcms\HttpExpressive1\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceVersionByRequest;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusPageBasic implements GetStatusPage
{
    /**
     * @var GetSiteCmsResourceVersionByRequest
     */
    protected $getSiteCmsResourceVersionByRequest;

    /**
     * @var FindBasicComponent
     */
    protected $findBasicComponent;

    /**
     * @param GetSiteCmsResourceVersionByRequest $getSiteCmsResourceVersionByRequest
     * @param FindBasicComponent                 $findBasicComponent
     */
    public function __construct(
        GetSiteCmsResourceVersionByRequest $getSiteCmsResourceVersionByRequest,
        FindBasicComponent $findBasicComponent
    ) {
        $this->getSiteCmsResourceVersionByRequest = $getSiteCmsResourceVersionByRequest;
        $this->findBasicComponent = $findBasicComponent;
    }

    /**
     * @param ServerRequestInterface $request
     * @param int                    $status
     *
     * @return null|string
     */
    public function __invoke(
        ServerRequestInterface $request,
        int $status
    ) {
        $status = (string)$status;

        /** @var HttpExpressiveComponent $component */
        $component = $this->findBasicComponent->__invoke(
            HttpExpressiveComponent::NAME
        );

        $statusPage = $component->findStatusPage($status);

        $siteResourceVersion = $this->getSiteCmsResourceVersionByRequest->__invoke($request);

        // Try to get the $statusPage from site
        if (!empty($siteResourceVersion)) {
            $siteVersion = $siteResourceVersion->getVersion();
            $statusPage = $siteVersion->findStatusPage(
                $status,
                $statusPage
            );
        }

        return $statusPage;

    }
}
