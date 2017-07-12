<?php

namespace Zrcms\Core\RenderData\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderDataCollection extends \IteratorAggregate
{
    /**
     * @param string $name
     * @param string $html
     * @param array  $params
     *
     * @return void
     */
    public function addNew(string $name, string $html, array $params = []);

    /**
     * @param RenderData $renderData
     *
     * @return void
     */
    public function add(RenderData $renderData);

    /**
     * @param string          $name
     * @param RenderData|null $default
     *
     * @return RenderData|null
     */
    public function get(string $name, RenderData $default = null);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name);

    /**
     * @param RenderDataCollection $renderDataCollection
     *
     * @return void
     */
    public function merge(RenderDataCollection $renderDataCollection);

    /**
     * @return array
     */
    public function __toArray();
}
