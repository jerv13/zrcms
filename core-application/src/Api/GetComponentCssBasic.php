<?php

namespace Zrcms\CoreApplication\Api;

use Psr\SimpleCache\InvalidArgumentException;
use Reliv\CacheRat\Service\Cache;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetComponentCssBasic extends GetComponentFilesContentAbstract implements GetComponentCss
{
    const SCHEME = 'component';
    const DEFAULT_CACHE_KEY = 'GetComponentCssBasic';

    protected $cache;
    protected $cacheKey;

    /**
     * @param Cache  $cache
     * @param string $cacheKey
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        parent::__construct(
            FieldsComponent::CSS,
            $cache,
            $cacheKey
        );
    }

    /**
     * @return string
     */
    protected function getScheme(): string
    {
        return static::SCHEME;
    }

    /**
     * @param string $filePathUri
     *
     * @return bool
     */
    protected function isValidScheme(string $filePathUri)
    {
        $scheme = parse_url($filePathUri, PHP_URL_SCHEME);

        // we are the default for empty schemes
        return ($scheme === $this->getScheme() || empty($scheme));
    }
}
