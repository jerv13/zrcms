<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;
use Zrcms\CoreApplication\Api\GetComponentFilesContentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetComponentJsAdminTools extends GetComponentFilesContentAbstract implements GetComponentJs
{
    const SCHEME = 'admin-tools';
    const DEFAULT_CACHE_KEY = 'GetComponentJsAdminTools';

    protected $isAllowedAdminTools;
    protected $isAllowedAdminToolsOptions;

    /**
     * @param IsAllowedAdminTools $isAllowedAdminTools
     * @param array               $isAllowedAdminToolsOptions
     * @param Cache               $cache
     * @param string              $cacheKey
     */
    public function __construct(
        IsAllowedAdminTools $isAllowedAdminTools,
        array $isAllowedAdminToolsOptions,
        Cache $cache,
        string $cacheKey = self::DEFAULT_CACHE_KEY
    ) {
        $this->isAllowedAdminTools = $isAllowedAdminTools;
        $this->isAllowedAdminToolsOptions = $isAllowedAdminToolsOptions;

        parent::__construct(
            FieldsComponent::JAVASCRIPT,
            $cache,
            $cacheKey
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $components
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $components,
        array $options = []
    ): string {
        $allowed = $this->isAllowedAdminTools->__invoke(
            $request,
            $this->isAllowedAdminToolsOptions
        );

        if (!$allowed) {
            return '';
        }

        return parent::__invoke($request, $components, $options);
    }

    /**
     * @return string
     */
    protected function getScheme(): string
    {
        return static::SCHEME;
    }
}
