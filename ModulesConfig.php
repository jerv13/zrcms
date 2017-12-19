<?php

namespace Zrcms;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModulesConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            // Low level
            new \Zrcms\Debug\ModuleConfig(),
            new \Zrcms\Logger\ModuleConfig(),
            new \Zrcms\Cache\ModuleConfig(),
            new \Zrcms\Param\ModuleConfig(),
            new \Zrcms\Mustache\ModuleConfig(),
            new \Zrcms\ServiceAlias\ModuleConfig(),

            new \Zrcms\Core\ModuleConfig(),

            // Mid level
            new \Zrcms\Acl\ModuleConfig(),
            new \Zrcms\Locale\ModuleConfig(),
            new \Zrcms\User\ModuleConfig(),

            new \Zrcms\CoreApplication\ModuleConfig(),
            new \Zrcms\CoreApplicationDoctrine\ModuleConfig(),

            new \Zrcms\CoreAdminTools\ModuleConfig(),
            new \Zrcms\CoreBlock\ModuleConfig(),
            new \Zrcms\CoreContainer\ModuleConfig(),
            new \Zrcms\CoreContainerDoctrine\ModuleConfig(),
            new \Zrcms\CoreCountry\ModuleConfig(),
            new \Zrcms\CoreLanguage\ModuleConfig(),
            new \Zrcms\CorePage\ModuleConfig(),
            new \Zrcms\CorePageDoctrine\ModuleConfig(),
            new \Zrcms\CoreRedirect\ModuleConfig(),
            new \Zrcms\CoreRedirectDoctrine\ModuleConfig(),
            new \Zrcms\CoreSite\ModuleConfig(),
            new \Zrcms\CoreSiteDoctrine\ModuleConfig(),
            new \Zrcms\CoreTheme\ModuleConfig(),
            new \Zrcms\CoreThemeDoctrine\ModuleConfig(),
            new \Zrcms\CoreView\ModuleConfig(),

            new \Zrcms\Importer\ModuleConfig(),
            new \Zrcms\Install\ModuleConfig(),

            new \Zrcms\ViewHead\ModuleConfig(),
            new \Zrcms\ViewHtmlTags\ModuleConfig(),

            new \Zrcms\Http\ModuleConfig(),

            new \Zrcms\HttpAssets\ModuleConfig(),

            new \Zrcms\HttpAssetsChangeLog\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpAssetsChangeLog\ModuleConfigRoutes(),

            new \Zrcms\HttpAssetsAdminTools\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpAssetsAdminTools\ModuleConfigRoutes(),

            new \Zrcms\HttpApi\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApi\ModuleConfigRoutes(),

            new \Zrcms\HttpAssetsBlock\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpAssetsBlock\ModuleConfigRoutes(),

            new \Zrcms\HttpApiContainer\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiContainer\ModuleConfigRoutes(),

            new \Zrcms\HttpApiCountry\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiCountry\ModuleConfigRoutes(),

            new \Zrcms\HttpApiLanguage\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiLanguage\ModuleConfigRoutes(),

            new \Zrcms\HttpApiPage\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiPage\ModuleConfigRoutes(),

            new \Zrcms\HttpApiRedirect\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiRedirect\ModuleConfigRoutes(),

            new \Zrcms\HttpApiSite\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiSite\ModuleConfigRoutes(),

            new \Zrcms\HttpApiTheme\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiTheme\ModuleConfigRoutes(),

            new \Zrcms\HttpApiView\ModuleConfig(),
            // @todo Routes should NOT be included by default
            new \Zrcms\HttpApiView\ModuleConfigRoutes(),

            new \Zrcms\HttpLocale\ModuleConfig(),
            new \Zrcms\HttpRcmApiLib\ModuleConfig(),
            new \Zrcms\HttpRedirect\ModuleConfig(),
            new \Zrcms\HttpSiteExists\ModuleConfig(),
            new \Zrcms\HttpStatusPages\ModuleConfig(),

            // @todo HttpTest should NOT be included by default
            new \Zrcms\HttpTest\ModuleConfig(),
            // @todo HttpTest Routes should NOT be included by default
            new \Zrcms\HttpTest\ModuleConfigRoutes(),

            new \Zrcms\HttpUser\ModuleConfig(),
            new \Zrcms\HttpViewRender\ModuleConfig(),

            // @todo XampleComponent should NOT be included by default
            new \Zrcms\XampleComponent\ModuleConfig(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
