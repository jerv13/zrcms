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
