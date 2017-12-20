<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;
use Zrcms\ViewHead\Model\ServiceAliasViewHead;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagServiceAliasStrategy implements RenderHeadSectionTag
{
    const PARAM_SERVICE_ALIAS_STRATEGY = 'renderer';

    protected $getServiceFromAlias;
    protected $configReaderServiceAliasNamespace;
    protected $defaultServiceAliasStrategy;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $configReaderServiceAliasNamespace
     * @param string              $defaultServiceAliasStrategy
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $configReaderServiceAliasNamespace = ServiceAliasViewHead::ZRCMS_VIEW_HEAD_RENDER_HEAD_SECTION_TAG,
        string $defaultServiceAliasStrategy = RenderHeadSectionTagBasic::SERVICE_ALIAS
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->configReaderServiceAliasNamespace = $configReaderServiceAliasNamespace;
        $this->defaultServiceAliasStrategy = $defaultServiceAliasStrategy;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $sectionConfig
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     * @throws \Zrcms\ServiceAlias\Exception\ServiceSelfReferenceException
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string {
        $renderStrategyServiceAlias = Param::getString(
            $sectionConfig,
            static::PARAM_SERVICE_ALIAS_STRATEGY,
            $this->defaultServiceAliasStrategy
        );

        /** @var RenderHeadSectionTag $renderHeadSectionTag */
        $renderHeadSectionTag = $this->getServiceFromAlias->__invoke(
            $this->configReaderServiceAliasNamespace,
            $renderStrategyServiceAlias,
            RenderHeadSectionTag::class,
            ''
        );

        ServiceCheck::assertNotSelfReference($this, $renderHeadSectionTag);

        unset($sectionConfig[static::PARAM_SERVICE_ALIAS_STRATEGY]);

        return $renderHeadSectionTag->__invoke(
            $request,
            $tag,
            $sectionEntryName,
            $sectionConfig,
            $options
        );
    }
}
