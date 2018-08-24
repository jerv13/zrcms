<?php

namespace Zrcms\CoreApplicationState\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\Json\Json;
use Zrcms\Core\Api\Render\Render;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Http\Response\ZrcmsJsonResponse;
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

        $encodingOptions = ZrcmsJsonResponse::DEFAULT_JSON_FLAGS;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        $indent = Property::getString(
            $options,
            RenderTag::OPTION_INDENT,
            '    '
        );

        $lineBreak = Property::getString(
            $options,
            RenderTag::OPTION_LINE_BREAK,
            "\n"
        );

        $json = Json::encode($appState, $encodingOptions);
        $content = "{$lineBreak}{$indent}    window.zrcmsApplicationState = {$json};{$lineBreak}{$indent}";
        $attributes = [
            'type' => 'text/javascript'
        ];

        if ($this->debug) {
            $attributes['data-name'] = 'zrcmsApplicationState';
        }

        return $this->renderTag->__invoke(
            [
                RenderTag::PROPERTY_TAG => 'script',
                RenderTag::PROPERTY_CONTENT => $content,
                RenderTag::PROPERTY_ATTRIBUTES => $attributes
            ]
        );
    }
}
