NOTES
=====

- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes
    
- Block instances might need be split from Page 
  (AKA: eliminate Page::getBlockVersions and replace with an API like BlockVersion\Api\FindBlockVersionsBy();
  
- Uri parser (get values from Uri)

## Can all config values and data values be properties ##

Allow for 100% over-riding of data in the instance
Allows for simpler implementation of Content objects
Allows for virtually arbitrary properties AKA easy to extend functionality

## Tracking ##
- Tracking: who (userId) - what (action) - why(reason)

## CLI helper ## 

ENV="local" ./bin/console rcm:export --file ./data/export.json --limit 1 --pp 1

ENV="local" ./bin/console zrcms:import --file ./data/export.json 

ENV="local" bin/console orm:schema-tool:update --dump-sql > ./data/0.0.0.sql

ENV="local" bin/console orm:schema-tool:update --force

## @todo ##

- NOTE: "directory" changed to "location" for components
- add <identifier> to comments
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated
        - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
    - Properties need to be synced between Content and array
    - 
- config factories: Arguments over-ride issue due to config merge
- Sync properties from columns in entities using $this->getProperties()
- Layout version might require themeName as property
- Need ViewDataGetters (port or wrap from ZF view helpers):
    - rcmGoogleAnalytics
    - browser-warning.html
    - rcmAdminPanel
    - rcmHtmlEditorOptions
    - basePath
    

            
- Document the architecture and basics of how it works
- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- Deal with service aliases so config can be simple

- Check all component Properties and config values
    - BLOCKS:
        - RENDERER
        - DATA_PROVIDER
        - ?RENDER_DATA_GETTER (not currently supported)
        
    - Layout
        - RENDERER
        - RENDER_DATA_GETTER
        - RENDER_TAG_NAME_PARSER
        
    - ViewRenderDataGatter
        - RENDER_DATA_GETTER
        
- GetServiceFromAlias and wire const NAMESPACE_RESOURCE = 'zrcms.view.resource';

- RENAME ViewRenderDataGetter to LayoutTag and rearrange code
    - NOTE: the pattern is different so split them @see GetViewRenderDataBasic
    - GetContentRenderData -> GetContentRenderTags
    - GetContentRenderData -> GetContentRenderTags
    
    - GetViewRenderData -> GetLayoutTags
    - ViewRenderDataGetter -> LayoutTagsGetter
    - NS ViewRenderDataGetter -> LayoutTags
    - VIEW_RENDER_DATA_GETTER -> RENDER_TAGS_GETTER
    - view-render-data-getter -> layout-tags-getter

- Refactor GetRegisterThemeComponentsBasic to use same interfaces as the rest

    /**
     * @param array $registryConfig
     *
     * @return array
     * @throws \Exception
     */
    protected function readConfigs(array $registryConfig)
    {
        $componentConfigs = [];

        foreach ($registryConfig as $componentNameOptional => $configLocation) {

            $componentOptions = [];
            $componentName = $componentNameOptional;

            $readComponentConfig = $this->readComponentConfig;

            if (is_array($configLocation)) {
                $componentOptions = $configLocation;
                $configLocation = Param::getRequired(
                    $componentOptions,
                    ComponentRegistryFields::CONFIG_LOCATION,
                    new \Exception(
                        'Component location is required for: ' . json_encode($configLocation)
                        . ' in ' . $this->componentClass
                    )
                );


                $readComponentConfig = Param::get(
                    $componentOptions,
                    ComponentRegistryFields::COMPONENT_CONFIG_READER,
                    $this->defaultComponentConfReaderServiceAlias
                );

                // @todo readComponentConfig injection here

                $componentName = Param::get(
                    $componentOptions,
                    ComponentRegistryFields::NAME,
                    $componentNameOptional
                );
            }

            $componentConfig = $this->readComponentConfig->__invoke(
                $configLocation,
                $componentOptions
            );

            if (!is_string($componentName)) {
                new \Exception(
                    'Component ' . ComponentConfigFields::NAME . ' is required and must be string for: '
                    . json_encode($componentConfig)
                    . ' in ' . $this->componentClass
                );
            }

            Param::assertNotHas(
                $componentConfig,
                $componentName,
                new \Exception(
                    'Duplicate component name configured: ' . $componentName
                    . ' for ' . $this->componentClass
                )
            );

            $componentConfigs[$componentName] = $componentConfig;
        }

        return $componentConfigs;
    }
