<?php

namespace Zrcms\HttpAssetsAdminTools\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderScriptSrcTagAdminTools extends RenderScriptSrcTag implements Render
{
    protected $isAllowedAdminTools;
    protected $isAllowedAdminToolsOptions;
    protected $debug;

    /**
     * @param IsAllowedAdminTools $isAllowedAdminTools
     * @param array               $isAllowedAdminToolsOptions
     * @param RenderTag           $renderTag
     * @param GetCacheBreaker     $getCacheBreaker
     * @param bool                $debug
     */
    public function __construct(
        IsAllowedAdminTools $isAllowedAdminTools,
        array $isAllowedAdminToolsOptions,
        RenderTag $renderTag,
        GetCacheBreaker $getCacheBreaker,
        bool $debug = false
    ) {
        $this->isAllowedAdminTools = $isAllowedAdminTools;
        $this->isAllowedAdminToolsOptions = $isAllowedAdminToolsOptions;
        $this->debug = $debug;

        parent::__construct(
            $renderTag,
            $getCacheBreaker
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param array|mixed            $attributes
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        $attributes,
        array $options = []
    ): string {
        $allowed = $this->isAllowedAdminTools->__invoke(
            $request,
            $this->isAllowedAdminToolsOptions
        );

        if (!$allowed) {
            return $this->renderNoop();
        }

        return parent::__invoke($request, $attributes, $options);
    }

    /**
     * @return string
     */
    protected function renderNoop(): string
    {
        if ($this->debug) {
            return '    <!-- NOT RENDERED ' . get_class($this) . ' -->';
        }

        return '';
    }
}
