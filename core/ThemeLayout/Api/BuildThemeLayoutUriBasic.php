<?php

namespace Zrcms\Core\Container\Api;

use Zrcms\ContentResourceUri\Api\BuildCmsUri;
use Zrcms\ContentResourceUri\Schema\UriSchemaThemeLayout;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildThemeLayoutUriBasic implements BuildThemeLayoutUri
{
    /**
     * @var BuildCmsUri
     */
    protected $buildCmsUri;

    /**
     * @param BuildCmsUri $buildCmsUri
     */
    public function __construct(
        BuildCmsUri $buildCmsUri
    ) {
        $this->buildCmsUri = $buildCmsUri;
    }

    /**
     * @param string   $themeName
     * @param string   $layoutName
     * @param int|null $siteId
     * @param array    $options
     *
     * @return string
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        int $siteId = null,
        array $options = []
    ): string
    {
        $path = $themeName . '/' . $layoutName;

        if ($siteId !== null) {
            /* @todo we may want ThemeLayouts to be tied to the site later */
            return $this->buildCmsUri->__invoke(
                $siteId,
                ThemeLayoutProperties::URI_NAMESPACE,
                $path,
                $options
            );
        }
xxx
        $values = [
            'type' => ThemeLayoutProperties::URI_NAMESPACE,
            'path' => $path
        ];

        $schema = '';

        foreach ($values as $key => $value) {
            $schema = str_replace('{{' . $key . '}}', '{{' . $value . '}}', UriSchemaThemeLayout::SCHEMA);
        }

        return $schema;

    }
}
