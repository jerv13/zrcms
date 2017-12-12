<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\CoreView\Model\ViewLayoutTagsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HeadSectionComponent extends ViewLayoutTagsComponent
{
    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @param string $sectionName
     * @param string $entryName
     * @param array  $value
     *
     * @return array
     * @throws \Exception
     */
    public function addSectionEntry(
        string $sectionName,
        string $entryName,
        array $value
    ): array ;

    /**
     * @return array
     */
    public function getSections(): array;

    /**
     * @param string $sectionName
     * @param string $entryName
     *
     * @return array|null
     */
    public function findSectionEntry(
        string $sectionName,
        string $entryName
    );
}
