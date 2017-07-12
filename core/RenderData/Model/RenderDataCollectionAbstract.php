<?php

namespace Zrcms\Core\RenderData\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderDataCollectionAbstract implements RenderDataCollection
{
    /**
     * @var array
     */
    protected $renderData = [];

    public function __construct(
        array $renderData = []
    ) {

    }

    /**
     * @param array $renderData
     *
     * @return void
     * @throws \Exception
     */
    public function addMultiple(array $renderData)
    {
        foreach ($renderData as $name => $html) {

        }
    }

    /**
     * @param string $name
     * @param string $html
     * @param array  $params
     *
     * @return void
     */
    public function addNew(string $name, string $html, array $params = [])
    {
        $renderData = new RenderDataBasic($name, $html, $params);

        $this->add($renderData);
    }

    /**
     * @param RenderData $renderData
     *
     * @return void
     * @throws \Exception
     */
    public function add(RenderData $renderData)
    {
        $name = $renderData->getName();

        if ($this->has($name)) {
            throw new \Exception("Render data ({$name}) in already set");
        }

        if (empty($name)) {
            throw new \Exception("Render data name is required");
        }

        $this->renderData[$name] = $renderData;
    }

    /**
     * @param string          $name
     * @param RenderData|null $default
     *
     * @return RenderData|null
     */
    public function get(string $name, RenderData $default = null)
    {
        if ($this->has($name)) {
            return $this->renderData[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return array_key_exists($name, $this->renderData);
    }

    /**
     * @param RenderDataCollection $renderDataCollection
     *
     * @return void
     */
    public function merge(RenderDataCollection $renderDataCollection)
    {
        foreach ($renderDataCollection as $name => $renderData) {
            $this->add($renderData);
        }
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return $this->renderData;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->__toArray());
    }
}
