<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @deprecated Handled by GetBlockInstanceRenderData
 * @author     James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceDataAbstract extends BlockInstanceAbstract implements BlockInstanceData
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $uri
     * @param string $sourceUri
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $blockName
     * @param array  $config
     * @param array  $layoutProperties
     * @param array  $data
     */
    public function __construct(
        string $uri,
        string $sourceUri,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $blockName,
        array $config,
        array $layoutProperties,
        array $data
    ) {
        $this->data = $data;

        parent::__construct(
            $uri,
            $sourceUri,
            $properties,
            $createdByUserId,
            $createdReason,
            $blockName,
            $config,
            $layoutProperties
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
