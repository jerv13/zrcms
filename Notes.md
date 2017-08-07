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
        - ?RENDER_TAGS_GETTER (not currently supported)
        
    - Layout
        - RENDERER
        - RENDER_TAGS_GETTER
        - RENDER_TAG_NAME_PARSER
        
    - ViewRenderDataGatter
        - RENDER_TAGS_GETTER
        
- GetServiceFromAlias and wire const NAMESPACE_RESOURCE = 'zrcms.view.resource';

- RENAME ViewLayoutTagsGetter to LayoutTag and rearrange code
    - NOTE: the pattern is different so split them @see GetViewRenderTagsBasic
    -x GetContentRenderTags -> GetContentRenderTags
    
    - GetViewRenderTags -> GetLayoutTags
    - ViewLayoutTagsGetter -> LayoutTagsGetter
    - NS ViewLayoutTagsGetter -> LayoutTags
    - VIEW_RENDER_TAGS_GETTER -> RENDER_TAGS_GETTER
    - view-layout-tags-getter -> layout-tags-getter

- Refactor GetRegisterThemeComponentsBasic to use same interfaces as the rest

- Fix caching (cache registry not components)
- 
