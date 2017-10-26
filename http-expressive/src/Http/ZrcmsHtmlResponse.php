<?php

namespace Zrcms\HttpExpressive\Http;

use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Content\Model\PropertiesTrait;
use Zrcms\ContentCore\Page\Fields\FieldsPageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ZrcmsHtmlResponse extends HtmlResponse
{
    use PropertiesTrait;

    const PROPERTY_TITLE = FieldsPageVersion::TITLE;
    const PROPERTY_DESCRIPTION = FieldsPageVersion::DESCRIPTION;
    const PROPERTY_KEYWORDS = FieldsPageVersion::KEYWORDS;
    const PROPERTY_LAYOUT = FieldsPageVersion::LAYOUT;
    const PROPERTY_RENDER_TAGS_GETTER = FieldsPageVersion::RENDER_TAGS_GETTER;
    const PROPERTY_BLOCK_VERSIONS = FieldsPageVersion::BLOCK_VERSIONS;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Create a ZRCMS HTML response.
     * 
     * @param StreamInterface|string $html
     * @param int                    $status
     * @param array                  $headers
     * @param array                  $properties
     */
    public function __construct(
        $html,
        $status = 200,
        array $headers = [],
        array $properties = []
    ) {
        $this->properties = $properties;

        parent::__construct(
            $html,
            $status,
            $headers
        );
    }

    /**
     * @param array $properties
     *
     * @return ZrcmsHtmlResponse
     */
    public function withProperties(array $properties)
    {
        $new = clone $this;
        $new->properties = $properties;
        return $new;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ZrcmsHtmlResponse
     */
    public function withProperty(string $key, $value)
    {
        $new = clone $this;
        $new->properties[$key] = $value;
        return $new;
    }
}
