@todo
=====

- Service to FindResourceVersion
    - return a CurrentVersionObject that has CmsResource and ContentVersion
    
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated
        - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
    - Properties need to be synced between Content and array

- config factories: Arguments over-ride issue due to config merge

- Need ViewDataGetters (port or wrap from ZF view helpers):
    - rcmGoogleAnalytics
    - browser-warning.html
    - rcmAdminPanel
    - rcmHtmlEditorOptions
    - basePath
  
- Document the architecture and basics of how it works

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- Check all component Properties and config values
    - Add getters where required

- Fix caching - should we avoid caching component objects in GetRegisterComponents?

- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes
    
- Optimize view-head
    - reduce loops
    - optimize BC
    - Use const for strings
    
