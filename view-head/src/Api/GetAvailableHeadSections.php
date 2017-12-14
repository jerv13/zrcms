<?php

namespace Zrcms\ViewHead\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetAvailableHeadSections
{
    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @param array $sections
     */
    public function __construct(
        array $sections
    ) {
        $this->order($sections);
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->sections;
    }

    /**
     * @param array $sections
     *
     * @return void
     */
    protected function order(array $sections)
    {
        $queue = new \SplPriorityQueue();

        foreach ($sections as $section) {
            $queue->insert($section['name'], $section['priority']);
        }

        foreach ($queue as $item) {
            $this->sections[] = $item;
        }
    }
}
