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

            new \Zrcms\ContentCoreConfigDataSource\ModuleConfig(),
            new \Zrcms\ContentCoreDoctrineDataSource\ModuleConfig(),
            new \Zrcms\ContentRedirectDoctrineDataSource\ModuleConfig(),

            new \Zrcms\HttpExpressive\ModuleAllConfig(),

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
