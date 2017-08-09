<?php

namespace Zrcms\ViewHead\Api\Render;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBc extends RenderHeadSectionsTagBasic implements RenderHeadSectionsTag
{
    protected $newKeysMap
        = [
            'pre-core' => 'pre-rcm',
            'core' => 'rcm',
            'post-core' => 'post-rcm',
        ];

    /**
     * @param RenderTag $renderTag
     * @param array     $availableSections
     * @param array     $availableSectionsBc
     */
    public function __construct(
        RenderTag $renderTag,
        array $availableSections,
        array $availableSectionsBc
    ) {
        $availableSections = $this->merge(
            $availableSections,
            $availableSectionsBc
        );

        parent::__construct($renderTag, $availableSections);
    }

    /**
     * @param array $availableSections
     * @param array $availableSectionsBc
     *
     * @return array
     */
    protected function merge(
        array $availableSections,
        array $availableSectionsBc
    ): array
    {
        $availableSectionsMerged = [];

        foreach ($availableSections as $availableSection) {
            if (isset($this->newKeysMap[$availableSection])) {
                $availableSectionsMerged[] = $this->newKeysMap[$availableSection];
            }
            $availableSectionsMerged[] = $availableSection;
        }

        // @todo might add some checking in case some keys change
        //foreach ($availableSectionsBc as $availableSectionBc) {
        //    if (!in_array($availableSectionBc, $availableSectionsMerged)) {
        //        throw new \Exception('undefined key');
        //    }
        //}

        return $availableSectionsMerged;
    }
}
