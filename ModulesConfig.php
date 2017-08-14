<?php

namespace Zrcms;

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
            new \Zrcms\ContentCore\ModuleConfig(),
            new \Zrcms\ContentCountry\ModuleConfig(),
            new \Zrcms\ContentLanguage\ModuleConfig(),
            new \Zrcms\Importer\ModuleConfig(),
            new \Zrcms\Install\ModuleConfig(),

            new \Zrcms\ViewHead\ModuleConfig(),
            new \Zrcms\ViewHtmlTags\ModuleConfig(),

            new \Zrcms\ContentCoreConfigDataSource\ModuleConfig(),
            new \Zrcms\ContentCoreDoctrineDataSource\ModuleConfig(),
            new \Zrcms\HttpExpressive1\ModuleConfig(),
            new \Zrcms\HttpResponseHandler\ModuleConfig(),

            // @todo REMOVE Xample
            new \Zrcms\XampleComponent\ModuleConfig(),
        ];

        $configManager = new \Zend\ConfigAggregator\ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
