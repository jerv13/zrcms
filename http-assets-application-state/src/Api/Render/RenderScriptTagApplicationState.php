<?php

namespace Zrcms\HttpAssetsApplicationState\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Json\Json;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderScriptTagApplicationState implements Render
{
    protected $getApplicationState;
    protected $renderTag;

    /**
     * @param GetApplicationState $getApplicationState
     * @param RenderTag           $renderTag
     */
    public function __construct(
        GetApplicationState $getApplicationState,
        RenderTag $renderTag
    ) {
        $this->getApplicationState = $getApplicationState;
        $this->renderTag = $renderTag;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array|mixed            $appState
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        ServerRequestInterface $request,
        $appState = [],
        array $options = []
    ): string {
        $appState = $this->getApplicationState->__invoke(
            $request,
            $appState
        );

        $json = Json::encode($appState);
        $content = 'window.zrcmsApplicationState = ' . $json . ';';

        return $this->renderTag->__invoke(
            [
                RenderTag::PROPERTY_TAG => 'script',
                RenderTag::PROPERTY_CONTENT => $content,
                RenderTag::PROPERTY_ATTRIBUTES => [
                    'type' => 'text/javascript'
                ],
            ]
        );
    }
}
