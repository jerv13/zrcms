<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceDataAbstract extends BlockInstanceAbstract implements BlockInstanceData
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $uid
     * @param string $uri
     * @param string $blockName
     * @param array  $config
     * @param array  $layoutProperties
     * @param array  $data
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $uri,
        string $blockName,
        array $config,
        array $layoutProperties,
        array $data,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->data = $data;
        parent::__construct(
            $uid,
            $uri,
            $blockName,
            $config,
            $layoutProperties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getDataValue(string $name, $default = null)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return $default;
    }
}
