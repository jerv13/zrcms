<?php

namespace Zrcms\Core\RenderData\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RenderDataAbstract
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param string $name
     * @param string $html
     * @param array  $params
     */
    public function __construct(
        string $name,
        string $html,
        array $params = []
    ) {
        $this->setName($name);
        $this->html = $html;
        $this->params = $params;
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    protected function setName(string $name)
    {
        if (!preg_match('^[A-Za-z0-9_\-\[\]\/]+$', $name)) {
            throw new \Exception('Invalid name');
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
