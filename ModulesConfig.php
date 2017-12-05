<?php

namespace Zrcms;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModulesConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            // Low level
            new \Zrcms\Cache\ModuleConfig(),
            new \Zrcms\Param\ModuleConfig(),
            new \Zrcms\Mustache\ModuleConfig(),
            new \Zrcms\Content\ModuleConfig(),
            new \Zrcms\ContentDoctrine\ModuleConfig(),
            new \Zrcms\ServiceAlias\ModuleConfig(),

            // Mid level
            new \Zrcms\Acl\ModuleConfig(),
            new \Zrcms\Locale\ModuleConfig(),
            new \Zrcms\User\ModuleConfig(),
            new \Zrcms\ContentCore\ModuleConfig(),
            new \Zrcms\ContentCountry\ModuleConfig(),
            new \Zrcms\ContentLanguage\ModuleConfig(),
            new \Zrcms\ContentRedirect\ModuleConfig(),

            new \Zrcms\Importer\ModuleConfig(),
            new \Zrcms\Install\ModuleConfig(),

            new \Zrcms\ViewAssets\ModuleConfig(),
            new \Zrcms\ViewHead\ModuleConfig(),
            new \Zrcms\ViewHtmlTags\ModuleConfig(),

            new \Zrcms\ContentCoreDoctrineDataSource\ModuleConfig(),
            new \Zrcms\ContentRedirectDoctrineDataSource\ModuleConfig(),

            new \Zrcms\Http\ModuleConfig(),
            new \Zrcms\HttpContent\ModuleConfig(),
            new \Zrcms\HttpContentSite\ModuleConfig(),
            new \Zrcms\HttpLocale\ModuleConfig(),
            new \Zrcms\HttpRcmApiLib\ModuleConfig(),
            new \Zrcms\HttpRedirect\ModuleConfig(),
            new \Zrcms\HttpSiteExists\ModuleConfig(),
            new \Zrcms\HttpStatusPages\ModuleConfig(),
            new \Zrcms\HttpTest\ModuleConfig(),
            new \Zrcms\HttpUser\ModuleConfig(),
            new \Zrcms\HttpViewRender\ModuleConfig(),

            new \Zrcms\ChangeLog\ModuleConfig(),

            // @todo REMOVE Xample
            new \Zrcms\XampleComponent\ModuleConfig(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
