<?php

namespace Zrcms\Mustache\Resolver;

use Phly\Mustache\Resolver\ResolverInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class StringResolver implements ResolverInterface
{
    const DEFAULT_NAMESPACE = '__DEFAULT__';

    /**
     * @var array
     */
    protected $templates
        = [
            self::DEFAULT_NAMESPACE => '<!-- TEMPLATE MISSING -->'
        ];

    /**
     * @param array $templates
     */
    public function __construct(
        array $templates = []
    ) {
        $this->addTemplates($templates);
    }

    /**
     * @param array $templates
     *
     * @return void
     */
    public function addTemplates(array $templates)
    {
        foreach ($templates as $name => $html) {
            $this->addTemplate($name, $html);
        }
    }

    /**
     * @param string $name
     * @param string $html
     *
     * @return void
     */
    public function addTemplate(string $name, string $html)
    {
        $this->templates[$name] = $html;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getTemplate(string $name)
    {
        if ($this->hasTemplate($name)) {
            return $this->templates[$name];
        }

        return $this->templates[self::DEFAULT_NAMESPACE];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasTemplate(string $name)
    {
        return array_key_exists($this->templates, $name);
    }

    /**
     * Resolve a template name
     *
     * Resolve a template name to mustache content or a set of tokens.
     *
     * @param  string $template
     *
     * @return string|array
     */
    public function resolve($template)
    {
        return $this->getTemplate($template);
    }
}
