<?php

namespace Zrcms\Core\Layout\Model;

use Zrcms\ContentVersionControl\Model\ContentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract extends ContentAbstract implements Layout
{
    /**
     * @var string
     */
    protected $html;

    /**
     * @var array
     */
    protected $properties
        = [
            // 'findContainerPathsByHtmlServiceName' => '{FindContainerPathsByHtmlServiceName}'
        ];

    /**
     * @param string $uri
     * @param string $sourceUri
     * @param string $html
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uri,
        string $sourceUri,
        string $html,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->html = $html;

        parent::__construct(
            $uri,
            $sourceUri,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
