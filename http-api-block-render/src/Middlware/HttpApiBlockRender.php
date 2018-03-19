<?php

namespace Zrcms\HttpApiBlockRender\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;
use Zrcms\CoreBlock\Model\BlockVersionBasic;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiBlockRender
{
    const SOURCE = 'block-render';
    const API_TYPE = 'zrcms-http-api';

    protected $findComponent;
    protected $getBlockRenderTags;
    protected $renderBlock;
    protected $getUserIdByRequest;
    protected $notFoundStatus;
    protected $badRequestStatus;
    protected $debug;

    /**
     * @param FindComponent      $findComponent
     * @param GetBlockRenderTags $getBlockRenderTags
     * @param RenderBlock        $renderBlock
     * @param GetUserIdByRequest $getUserIdByRequest
     * @param int                $notFoundStatus
     * @param bool               $debug
     */
    public function __construct(
        FindComponent $findComponent,
        GetBlockRenderTags $getBlockRenderTags,
        RenderBlock $renderBlock,
        GetUserIdByRequest $getUserIdByRequest,
        int $notFoundStatus = 404,
        bool $debug = false
    ) {
        $this->findComponent = $findComponent;
        $this->getBlockRenderTags = $getBlockRenderTags;
        $this->renderBlock = $renderBlock;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->notFoundStatus = $notFoundStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $blockComponentName = (string)$this->getBlockComponentName($request);

        $blockComponent = $this->findComponent->__invoke(
            'block',
            $blockComponentName
        );

        if (empty($blockComponent)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    'Not Found with block component name: ' . $blockComponentName,
                    self::API_TYPE,
                    self::SOURCE
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        $blockVersionData = $this->getBlockVersionData($request);

        $blockVersion = new BlockVersionBasic(
            $blockVersionData['id'],
            $blockVersionData['properties'],
            $blockVersionData['createdByUserId'],
            $blockVersionData['createdReason'],
            $blockVersionData['createdDate']
        );

        $renderTags = $this->getBlockRenderTags->__invoke(
            $blockVersion,
            $request
        );

        $html = $this->renderBlock->__invoke(
            $blockVersion,
            $renderTags
        );

        $blockVersionData['html'] = $html;

        return new ZrcmsJsonResponse(
            $blockVersionData
        );
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return null|string
     */
    protected function getBlockComponentName(ServerRequestInterface $request)
    {
        $blockVersionProperties = $request->getParsedBody();

        return Property::getString(
            $blockVersionProperties,
            FieldsBlockVersion::BLOCK_COMPONENT_NAME,
            null
        );
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    protected function getBlockVersionData(
        ServerRequestInterface $request
    ): array {
        $blockVersionProperties = $request->getParsedBody();

        $blockVersionData['id'] = null;

        $blockVersionData['properties'] = $blockVersionProperties;

        $blockVersionData['createdByUserId'] = $this->getUserIdByRequest->__invoke(
            $request
        );

        $blockVersionData['createdReason'] = 'zrcms-http-api-render-block';

        $blockVersionData['createdDate'] = null;

        return $blockVersionData;
    }
}
