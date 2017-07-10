<?php

namespace Zrcms\Core\Layout\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutAbstract implements Layout
{
    protected $uid;
    protected $uri;
    protected $html;
    protected $properties = [
        // 'findContainerPathsByHtmlServiceName' => '{FindContainerPathsByHtmlServiceName}'
    ];

    /**
     * @param string $uid
     * @param string $uri
     * @param string $html
     * @param array  $properties
     */
    public function __construct(
        string $uid,
        string $uri,
        string $html,
        array $properties
    ) {
        $this->uid = $uid;
        $this->uri = $uri;
        $this->html = $html;
        $this->properties = $properties;
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
