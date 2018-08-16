<?php

namespace Zrcms\PageAccess\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\PageAccess\Fields\FieldsPageAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStatePageAccess implements GetApplicationState
{
    const APPLICATION_STATE_KEY = 'page-access';

    protected $getViewByRequest;
    protected $getViewByRequestOptions;
    protected $debug;

    /**
     * @param GetViewByRequest              $getViewByRequest
     * @param array                         $getViewByRequestOptions
     * @param bool                          $debug
     */
    public function __construct(
        GetViewByRequest $getViewByRequest,
        array $getViewByRequestOptions = [],
        bool $debug = false
    ) {
        $this->getViewByRequest = $getViewByRequest;
        $this->getViewByRequestOptions = $getViewByRequestOptions;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        try {
            $view = $this->getViewByRequest->__invoke(
                $request,
                $this->getViewByRequestOptions
            );
        } catch (ViewDataNotFound $exception) {
            $view = null;
        }

        $pageAccessState = [
            FieldsPageAccess::PAGE_ACCESS_OPTIONS => [],
        ];

        if (empty($view)) {
            return $pageAccessState;
        }
        $pageCmsResource = $view->getPageCmsResource();

        $pageState[FieldsPageAccess::PAGE_ACCESS_OPTIONS] = $pageCmsResource->getContentVersion()->findProperty(
            FieldsPageAccess::PAGE_ACCESS_OPTIONS,
            []
        );

        return $pageState;
    }
}
