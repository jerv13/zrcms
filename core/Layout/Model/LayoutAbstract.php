<?php

namespace Zrcms\Core\Layout\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract implements Layout
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $uri;

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
     * @param string $uid
     * @param string $uri
     * @param string $html
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $uri,
        string $html,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // if has id it is immutable
        if (!empty($this->uid)) {
            return;
        }
        $this->uid = $uid;
        $this->uri = $uri;
        $this->html = $html;
        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * <identifier>
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(string $name, $default = null)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return $default;
    }
}
