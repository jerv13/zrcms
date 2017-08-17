@todo
=====

- Implement Content pattern for page templates PageTemplateResource extends PageContainer
    - Add NOOP services
    - Exporter needs updateing
    
- Redirects
    - setup properties
    - setup entities
    - remove any host refs
    
- BuildView should use a component, not config
    
- Document the architecture and basics of how it works

- Doctrine FindXXXsBy need to be made to work better with properties
    
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated
        - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
    - Properties need to be synced between Content and array

- config factories: Arguments over-ride issue due to config merge

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- Check all component Properties and config values
    - Add getters where required
    
## OPTIMIZATION: api (after FindResourceVersion implemented) ##

- Optimize queries
- Add indexes
- GetViewLayoutTagsBasic - See @todo in class
- view-head
    - reduce loops
    - optimize BC
    - Use const for strings
- Caching
    - Create file caching service (not just array cache)


Zrcms\ContentCoreConfigDataSource\Block\Api\Component\ReadBlockComponent Zrcms\ContentCoreConfigDataSource\Block\Api\Component\ReadBlockComponent

## DONE ##

- Add placeholder services (NOOP) services to service container config for Find CMS resource APIs
    
-x View pipeline (BuildViewComposite) (allow others to use or add to the View at runtime)

-x Handlers for request status
    -x This may require our own pipe
    -x injectable middleware the says what to do on non-200 status codes
