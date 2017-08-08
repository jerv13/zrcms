<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Zrcms\Content\Api\Repository\ReadComponentConfigApplicationConfigAbstract;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsHeadComponentConfigApplicationConfigBc
    extends ReadComponentConfigApplicationConfigAbstract
    implements ReadViewLayoutTagsComponentConfig
{
    /**
     * @param array $applicationConfig
     * @param array $applicationConfigBc
     */
    public function __construct(
        array $applicationConfig,
        array $applicationConfigBc
    ) {


        parent::__construct($applicationConfig);
    }

    protected function mergeConfig(): array
    {

        $applicationConfig = array_merge_recursive(
            $applicationConfigBc,
            $applicationConfig
        );
    }
}
