@todo
=====

- Service to FindResourceVersion
    - return a CurrentVersionObject that has CmsResource and ContentVersion
    - NOTE: Should CmsResource interface contain no version and CmsResourceVersion have an ID and content

- Page properties from rcm
    - GetViewLayoutMetaPageData
    
- Optimize api (after FindResourceVersion implemented)
    - Optimize queries
    - Add indexes
    
-x View pipeline (BuildViewComposite) (allow others to use or add to the View at runtime)

-x Handlers for request status
    -x This may require our own pipe
    -x injectable middleware the says what to do on non-200 status codes
    
- Page templates - create content pattern!

- How to handle [age types = product pages
    
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated
        - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
    - Properties need to be synced between Content and array

- config factories: Arguments over-ride issue due to config merge

- Document the architecture and basics of how it works

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- Check all component Properties and config values
    - Add getters where required

- Fix caching - should we avoid caching component objects in GetRegisterComponents?

- Optimize view-head
    - reduce loops
    - optimize BC
    - Use const for strings
    
- RCM User needs PSR7 request interface
    - Get user from request
    - IsAllowed PHP API
    -
