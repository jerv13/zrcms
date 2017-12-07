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
            new \Zrcms\ServiceAlias\ModuleConfig(),

            new \Zrcms\Core\ModuleConfig(),

            // Mid level
            new \Zrcms\Acl\ModuleConfig(),
            new \Zrcms\Locale\ModuleConfig(),
            new \Zrcms\User\ModuleConfig(),

            new \Zrcms\CoreApplication\ModuleConfig(),
            new \Zrcms\CoreApplicationDoctrine\ModuleConfig(),

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

            new \Zrcms\ViewAssets\ModuleConfig(),
            new \Zrcms\ViewHead\ModuleConfig(),
            new \Zrcms\ViewHtmlTags\ModuleConfig(),

            new \Zrcms\Http\ModuleConfig(),
            new \Zrcms\HttpChangeLog\ModuleConfig(),
            new \Zrcms\HttpCore\ModuleConfig(),
            new \Zrcms\HttpCoreSite\ModuleConfig(),
            new \Zrcms\HttpLocale\ModuleConfig(),
            new \Zrcms\HttpRcmApiLib\ModuleConfig(),
            new \Zrcms\HttpRedirect\ModuleConfig(),
            new \Zrcms\HttpSiteExists\ModuleConfig(),
            new \Zrcms\HttpStatusPages\ModuleConfig(),
            new \Zrcms\HttpTest\ModuleConfig(),
            new \Zrcms\HttpUser\ModuleConfig(),
            new \Zrcms\HttpViewRender\ModuleConfig(),

            // @todo REMOVE Xample
            new \Zrcms\XampleComponent\ModuleConfig(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
