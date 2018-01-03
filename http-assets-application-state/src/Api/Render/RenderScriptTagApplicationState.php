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
    protected $debug;

    /**
     * @param GetApplicationState $getApplicationState
     * @param RenderTag           $renderTag
     * @param bool                $debug
     */
    public function __construct(
        GetApplicationState $getApplicationState,
        RenderTag $renderTag,
        bool $debug = false
    ) {
        $this->getApplicationState = $getApplicationState;
        $this->renderTag = $renderTag;
        $this->debug = $debug;
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

        $encodingOptions = 0;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        $json = Json::encode($appState, $encodingOptions);
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
