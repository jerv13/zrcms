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
            new \Zrcms\Fields\ModuleConfig(),
            new \Zrcms\Json\ModuleConfig(),
            new \Zrcms\Param\ModuleConfig(),
            new \Zrcms\Mustache\ModuleConfig(),
            new \Zrcms\ServiceAlias\ModuleConfig(),
            new \Zrcms\InputValidation\ModuleConfig(),
            new \Zrcms\InputValidationMessages\ModuleConfig(),
            new \Zrcms\InputValidationZf2\ModuleConfig(),
            new \Zrcms\InputValidationZrcms\ModuleConfig(),

            new \Zrcms\Core\ModuleConfig(),

            // Mid level
            new \Zrcms\Acl\ModuleConfig(),
            new \Zrcms\Locale\ModuleConfig(),
            new \Zrcms\User\ModuleConfig(),

            new \Zrcms\CoreApplication\ModuleConfig(),
            new \Zrcms\CoreApplicationDoctrine\ModuleConfig(),
            new \Zrcms\CoreApplicationState\ModuleConfig(),

            new \Zrcms\CoreAdminTools\ModuleConfig(),
            new \Zrcms\CoreBlock\ModuleConfig(),
            new \Zrcms\CoreContainer\ModuleConfig(),
            new \Zrcms\CoreContainerDoctrine\ModuleConfig(),
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
            new \Zrcms\HttpApi\ModuleConfig(),
            new \Zrcms\HttpApiContainer\ModuleConfig(),
            new \Zrcms\HttpApiCountry\ModuleConfig(),
            new \Zrcms\HttpApiFields\ModuleConfig(),
            new \Zrcms\HttpApiInputValidationMessages\ModuleConfig(),
            new \Zrcms\HttpApiLanguage\ModuleConfig(),
            new \Zrcms\HttpApiPage\ModuleConfig(),
            new \Zrcms\HttpApiRedirect\ModuleConfig(),
            new \Zrcms\HttpApiSite\ModuleConfig(),
            new \Zrcms\HttpApiTheme\ModuleConfig(),
            new \Zrcms\HttpApiView\ModuleConfig(),

            new \Zrcms\HttpAssets\ModuleConfig(),
            new \Zrcms\HttpAssetsAdminTools\ModuleConfig(),
            new \Zrcms\HttpApplicationState\ModuleConfig(),
            new \Zrcms\HttpChangeLog\ModuleConfig(),

            new \Zrcms\HttpLocale\ModuleConfig(),
            new \Zrcms\HttpRcmApiLib\ModuleConfig(),
            new \Zrcms\HttpRedirect\ModuleConfig(),
            new \Zrcms\HttpSiteExists\ModuleConfig(),
            new \Zrcms\HttpStatusPages\ModuleConfig(),

            new \Zrcms\SwaggerExpressiveZrcms\ModuleConfig(),

            // @todo HttpTest should NOT be included by default
            new \Zrcms\HttpTest\ModuleConfig(),

            new \Zrcms\HttpUser\ModuleConfig(),
            new \Zrcms\HttpViewRender\ModuleConfig(),

            new \Zrcms\PageAccess\ModuleConfig(),

            // @todo XampleComponent should NOT be included by default
            new \Zrcms\XampleComponent\ModuleConfig(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
